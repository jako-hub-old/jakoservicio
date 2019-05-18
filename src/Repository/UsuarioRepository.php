<?php

namespace App\Repository;

use App\Classes\Publicador;
use App\Classes\Utilidades;
use App\Entity\Invitado;
use App\Entity\Jugador;
use App\Entity\JugadorSolicitud;
use App\Entity\Transaccion;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * @param $filtros
     * @return mixed
     */
    public function lista($filtros)
    {
        $em = $this->getEntityManager();
        $usuario = $filtros['usuario']?? false;

        $qb = $em->createQueryBuilder();
        $qb->from(Usuario::class, "u")
            ->select("u.codigoUsuarioPk as codigo_usuario")
            ->addSelect("u.codigoJugadorFk as codigo_jugador")
            ->addSelect("u.usuario")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->leftJoin("u.jugadorRel", "j");

        # Filtros
        if($usuario !== false) {
            $qb->andWhere("u.usuario = '{$usuario}'");
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $datos
     * @param $publicador Publicador
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function validar($datos, $publicador) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        $imei = $datos['imei']?? '';
        if($usuario && $imei) {
            $arUsuario = $this->usuarioIngreso($usuario, $imei, $publicador);
            if($arUsuario->getEstadoVerificado()) {
                if($imei == $arUsuario->getImei()) {
                    return [
                        "verificado"     => true,
                        "codigo_usuario" => $arUsuario->getCodigoUsuarioPk(),
                        "crear_juego"    => $arUsuario->getCrearJuego(),
                    ];
                } else {
                    $codigo = $this->generarCodigo(4);
                    $arUsuario->setCodigoVerificacion($codigo);
                    $arUsuario->setImei($imei);
                    $arUsuario->setEstadoVerificado(0);
                    $em->persist($arUsuario);
                    $em->flush();
                    $this->enviarCodigo($usuario, $codigo);
                    return [
                        "verificado" => false
                    ];
                }
            } else {
                $codigo = $this->generarCodigo(4);
                $arUsuario->setCodigoVerificacion($codigo);
                $arUsuario->setImei($imei);
                $em->persist($arUsuario);
                $em->flush();
                $this->enviarCodigo($usuario, $codigo);
                return [
                    "verificado" => false
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $usuario
     * @param $imei
     * @param $publicador Publicador
     * @return Usuario|object|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function usuarioIngreso($usuario, $imei, $publicador) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
        if(!$arUsuario) {
            $arJugador = new Jugador();
            $em->persist($arJugador);
            $em->flush();

            $arUsuario = new Usuario();
            $arUsuario->setCodigoUsuarioPk($arJugador->getCodigoJugadorPk());
            $arUsuario->setUsuario($usuario);
            $arUsuario->setJugadorRel($arJugador);
            $arUsuario->setImei($imei);
            $arUsuario->setCrearJuego(1);
            $arUsuario->setFechaRegistro(new \DateTime("now"));
            $em->persist($arUsuario);
            $em->flush();
            $this->revisarInvitacion($usuario, $arJugador);
            $em->getRepository(Transaccion::class)->aplicar(100000, 100, $arJugador, 1, "Bono regalo inicial");
            $puntos = 100;
            $mensajeBono = "Disfruta de tu bono inicial por {$puntos}pts para que puedas crear y unirte a Juegos en Jako";
            $publicador->publicarNoticia($mensajeBono, Publicador::TIPO_NOTICIA, $arJugador, null, true, true);
            $mensajeBienvenida = "¡Te damos la bienvenida a Jako! Contacta amigos, Organiza tus propios juegos, Invita a tus amigos y ¡disfruta!";
            $publicador->publicarNoticia($mensajeBienvenida, Publicador::TIPO_NOTICIA, $arJugador, null, true, true);
        }
        return $arUsuario;
    }

    /**
     * @param $telefono
     * @param $arJugador Jugador
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function revisarInvitacion($telefono, $arJugadorInvitado) {
        if(strlen($telefono) > 10) {
            $telefono = strrev(substr(strrev($telefono), 0, 10));
        }
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Invitado::class, "i")
            ->select("i")
            ->where("i.telefonoInvitado = '{$telefono}'")
            ->setMaxResults(1);
        /**
         * @var Invitado $arInvitado
         */
        $arInvitado = $em->getRepository(Invitado::class)->findOneBy(["telefonoInvitado" => $telefono]);
        if($arInvitado) {
            $arInvitado->setRegistrado(true);
            $arJugadorInvita = $arInvitado->getJugadorRel();
            $arSolicitud = new JugadorSolicitud();
            $arSolicitud->setJugadorRel($arJugadorInvita);
            $arSolicitud->setJugadorSolicitudRel($arJugadorInvitado);
            $arSolicitud->setEstadoAceptado(false);
            $arSolicitud->setEstadoRespuesta(false);
            $em->persist($arSolicitud);
            $em->persist($arInvitado);
            $em->flush();
        }
    }

    private function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    private function enviarCodigo($telefono, $codigo) {
            $basic  = new \Nexmo\Client\Credentials\Basic(getenv('NEXMO_KEY'), getenv('NEXMO_SECRET'));
            $client = new \Nexmo\Client($basic);
            $message = $client->message()->send([
                'to' => "57{$telefono}",
                'from' => 'jakoservicio',
                'text' => "[Wojoo] Tu codigo es: {$codigo}"
            ]);
    }

    public function verificar($datos) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        $imei = $datos['imei']?? '';
        $codigo = $datos['codigo']?? '';
        if($usuario && $imei && $codigo) {
            $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
            if($arUsuario->getCodigoVerificacion() == $codigo && $arUsuario->getImei() == $imei) {
                $arUsuario->setEstadoVerificado(1);
                $em->persist($arUsuario);
                $em->flush();
                return [
                    'verificado' => true,
                    'codigo_usuario' => $arUsuario->getCodigoUsuarioPk(),
                    'crear_juego' => $arUsuario->getCrearJuego(),
                ];
            } else {
                return false;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function informacionUsuario($raw) {
        $codigoUsuario = $raw['codigo_usuario']?? '0';
        if($codigoUsuario) {
            $em = $this->getEntityManager();
            $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
            if($arUsuario && $arUsuario instanceof Usuario) {
                $arJugador = $arUsuario->getJugadorRel();
                return [
                    'identificacion'    => $arJugador->getIdentificacion(),
                    'nombre'            => $arJugador->getNombre(),
                    'nombre_corto'      => $arJugador->getNombreCorto(),
                    'apellido'          => $arJugador->getApellido(),
                    'correo'            => $arJugador->getCorreo(),
                    'foto'              => $arJugador->getFoto(),
                    'thumb'             => $arJugador->getFotoMiniatura(),
                    'puntos'            => $arUsuario->getPuntos(),
                    'seudonimo'         => $arJugador->getSeudonimo(),
                ];
            } else {
                return [
                    'validacion' => Utilidades::validacion(10)
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }


    }

    public function guardarFCMToken($raw) {
        $usuario = $raw['usuario']?? '0';
        $token = $raw['token'];
        if($usuario && $token) {
            $em = $this->getEntityManager();
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if($arUsuario) {
                $arUsuario->setFcmToken($token);
                $em->persist($arUsuario);
                $em->flush($arUsuario);
                return true;
            } else {
                return [
                    'validacion' => Utilidades::validacion(10)
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

}
