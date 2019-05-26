<?php

namespace App\Repository;

use App\Classes\ManejadorDeArchivos;
use App\Classes\Utilidades;
use App\Entity\Interes;
use App\Entity\InteresJugador;
use App\Entity\Jugador;
use App\Entity\JugadorAmigo;
use App\Entity\JugadorSolicitud;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JugadorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Jugador::class);
    }

    public function amigos($datos)
    {
        $em = $this->getEntityManager();
        $jugador = $datos['jugador']?? false;
        if($jugador) {
            $qb = $em->createQueryBuilder();
            $qb->from(JugadorAmigo::class, "ja")
                ->select("ja.codigoJugadorAmigoPk as codigo_jugador_amigo_pk")
                ->addSelect("ja.codigoJugadorAmigoFk as codigo_jugador_amigo")
                ->addSelect("jar.nombreCorto as jugador_amigo_rel_nombre_corto")
                ->addSelect("jar.seudonimo")
                ->addSelect("jar.foto")
                ->leftJoin("ja.jugadorAmigoRel", "jar")
                ->where("ja.codigoJugadorFk ={$jugador}");
            $arJugadorAmigos =  $qb->getQuery()->getResult();
            return $arJugadorAmigos;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function buscar()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Jugador::class, "j")
            ->select("j.codigoJugadorPk as codigo_jugador")
            ->addSelect("j.nombreCorto as nombre_corto")
            ->addSelect("j.seudonimo")
            ->addSelect("j.fotoMiniatura as foto")
            ->addSelect("u.usuario")
            ->leftJoin("j.usuariosJugadorRel", "u")
            ->where("j.seudonimo IS NOT NULL");
        $arJugadores =  $qb->getQuery()->getResult();
        return $arJugadores;

    }

    public function informacionComplementaria($raw) {
        $em = $this->getEntityManager();
        $usuario = $raw['usuario']?? 0;
        $seudonimo = $raw['seudonimo']?? '';
        $nombreCorto = $raw['nombre_corto']?? '';
        $intereses = $raw['intereses']?? [];
        $correo = $raw['correo']?? '';
        if($usuario && $seudonimo && $nombreCorto && $correo) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            $arJugador = $arUsuario->getJugadorRel();
            $qb = $em->createQueryBuilder()->from(Jugador::class, "j")
                ->select("j")
                ->where("j.seudonimo = '{$seudonimo}'")
                ->andWhere("j.codigoJugadorPk <> '{$arJugador->getCodigoJugadorPk()}'")
                ->setMaxResults(1);
            $arrExistente = $qb->getQuery()->getResult();
            if($arrExistente) {
                return [
                    'validacion' => Utilidades::validacion(9),
                ];
            } else {
                $arJugador->setSeudonimo($seudonimo);
                $arJugador->setCorreo($correo);
                $arJugador->setNombreCorto($nombreCorto);
                # Guardamos los intereses
                foreach ($intereses as $interes) {
                    $arInteres = $em->getRepository(Interes::class)->find($interes);
                    if($arInteres && $arInteres instanceof  Interes) {
                        $arInteresJugador = new InteresJugador();
                        $arInteresJugador->setJugadorRel($arJugador);
                        $arInteresJugador->setInteresRel($arInteres);
                        $em->persist($arInteresJugador);
                    }
                }
                $em->persist($arJugador);
                $em->flush();
                return true;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function detalle($raw)
    {
        $em = $this->getEntityManager();
        $jugador = $raw['jugador']?? false;
        if($jugador) {
            $qb = $em->createQueryBuilder();
            $qb->from(Jugador::class, "j")
                ->select("j.codigoJugadorPk as codigo_jugador")
                ->addSelect("j.nombreCorto as nombre_corto")
                ->addSelect("j.seudonimo")
                ->addSelect('j.correo')
                ->addSelect('j.juegos')
                ->addSelect('j.foto as foto_original')
                ->addSelect('j.fotoMiniatura as foto')
                ->addSelect('j.asistencia')
                ->addSelect('j.inasistencia')
            ->where("j.codigoJugadorPk = ${jugador}");
            $arJugador =  $qb->getQuery()->getResult();
            return $arJugador;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }


    }

    public function guardarFoto($codigoJugador, $urlFoto, $urlMiniatura) {
        $em = $this->getEntityManager();
        $jugador = $em->getRepository(Jugador::class)->find($codigoJugador);
        if($jugador) {
            $fotoAnterior = $jugador->getFoto();
            $thumb = $jugador->getFotoMiniatura();
            if($fotoAnterior) { # Borramos del sistema de archivos la foto anterior.
                $dirPublico = ManejadorDeArchivos::getDirectorioPublico();
                $rutaFoto = $dirPublico . "/{$fotoAnterior}";
                $rutaThumb = $dirPublico . "/{$thumb}";
                if(file_exists($rutaFoto)) {
                    unlink($rutaFoto);
                    unlink($rutaThumb);
                }
            }
            $jugador->setFoto($urlFoto);
            if($urlMiniatura) {
                $jugador->setFotoMiniatura($urlMiniatura);
            }
            $em->persist($jugador);
            $em->flush();
            return true;
        } else {
            return [
                'error_controlado' => Utilidades::error(3),
            ];
        }
    }

    /**
     * @param $raw
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function listarInformacionComplementaria($raw){
        $em            = $this->getEntityManager();
        $codigoJugador = $raw['jugador']??null;
        $jugador       = $em->getRepository(Jugador::class)->find($codigoJugador);

        if($jugador){
            $qb = $em->createQueryBuilder();
            $qb->from(Jugador::class, "j")
                ->select("j.codigoJugadorPk as codigo_jugador")
                ->addSelect("j.nombreCorto as nombre_corto")
                ->addSelect("j.seudonimo")
                ->addSelect('j.correo')
                ->where("j.codigoJugadorPk = {$codigoJugador}");
            $icJugador =  $qb->getQuery()->getOneOrNullResult();

            return $icJugador;
        } else {
            return [
                'error_controlado' => Utilidades::error(3)
            ];
        }
    }

    /**
     * @param $raw
     * @return array|bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarInformacionComplementaria($raw){
        $em          = $this->getEntityManager();
        $usuario     = $raw['usuario']?? 0;
        $seudonimo   = $raw['seudonimo']?? '';
        $nombreCorto = $raw['nombre_corto']?? '';
        $correo      = $raw['correo']?? '';

        if($usuario && $seudonimo && $nombreCorto && $correo) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            $arJugador = $arUsuario->getJugadorRel();
            $qb = $em->createQueryBuilder()->from(Jugador::class, "j")
                ->select("j")
                ->where("j.seudonimo = '{$seudonimo}'")
                ->andWhere("j.codigoJugadorPk  = '{$arJugador->getCodigoJugadorPk()}'")
                ->setMaxResults(1);
            $arrExistente = $qb->getQuery()->getResult();
            if($arrExistente) {
                return [
                    'validacion' => Utilidades::validacion(9),
                ];
            } else {
                $arJugador->setSeudonimo($seudonimo);
                $arJugador->setCorreo($correo);
                $arJugador->setNombreCorto($nombreCorto);
                $em->persist($arJugador);
                $em->flush();
                return true;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

}
