<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Jugador;
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
     * @return array|bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function nuevo($datos) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        if($usuario) {
            $usuarioExiste = $em->getRepository(Usuario::class)->validarUsuarioExiste($usuario);
            if(!$usuarioExiste) {
                $arJugador = new Jugador();
                $em->persist($arJugador);
                $em->flush();

                $codigo = $this->generarCodigo(6);
                $arUsuario = new Usuario();
                $arUsuario->setCodigoUsuarioPk($arJugador->getCodigoJugadorPk());
                $arUsuario->setUsuario($usuario);
                $arUsuario->setCodigoVerificacion($codigo);
                $arUsuario->setJugadorRel($arJugador);
                $em->persist($arUsuario);
                $em->flush();

                return true;
            } else {
                return [
                    'validacion' => Utilidades::validacion(1),
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    private function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    /**
     * @param $usuario
     * @return bool
     */
    public function validarUsuarioExiste($usuario) {
        $em = $this->getEntityManager();
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
        return $arUsuario ? true : false;
    }

    /**
     * @param $datos
     * @return array|bool
     */
    public function autenticar($datos) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        $codigo = $datos['codigo_verificacion']?? '';
        if($usuario && $codigo) {
            $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario, 'codigoVerificacion' => $codigo]);
            if($arUsuario) {
                return true;
            } else {
                return false;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

}
