<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Interes;
use App\Entity\InteresJugador;
use App\Entity\Jugador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Interes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interes[]    findAll()
 * @method Interes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Interes::class);
    }

    public function lista() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
                ->from(Interes::class, "i")
                ->select("i.codigoInteresPk as codigo_interes")
                ->addSelect("i.nombre")
                ->addSelect("i.descripcion")
                ->addSelect("i.icono");
        return $qb->getQuery()->getResult();
    }

    public function jugador($data) {
        $em = $this->getEntityManager();
        $jugador = $data['jugador']?? null;
        if($jugador) {
            $qbInteresesJugador = $em->createQueryBuilder();
            $qbInteresesJugador->from(InteresJugador::class, "ij")
                ->select("ij.codigoInteresFk")
                ->where("ij.codigoJugadorFk = '{$jugador}'");

            $qb = $em->createQueryBuilder()
                ->from(Interes::class, "i")
                ->select("i.codigoInteresPk as codigo_interes")
                ->addSelect("i.nombre")
                ->addSelect("i.descripcion")
                ->addSelect("i.icono")
                ->where("i.codigoInteresPk IN ({$qbInteresesJugador})");

            return $qb->getQuery()->getResult();
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }


    public function jugadorActualizar($data) {
        $em = $this->getEntityManager();
        $jugador = $data['jugador']?? null;
        $intereses = $data['intereses']?? null;
        if($jugador) {
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            if(!$arJugador) {
                return [ 'error_controlado' => Utilidades::error(2)];
            }
            $arInteresesJugador = $em->getRepository(InteresJugador::class)->findBy(['codigoJugadorFk' => $jugador]);
            # Borramos los intereses que no vienen en el array
            foreach ($arInteresesJugador as $key => $arInteresJugador) {
                if(in_array($arInteresJugador->getCodigoInteresFk(), $intereses)) { # Si se encuentra en el array de intereses enviado no lo procesamos.
                    $indice = array_search($arInteresJugador->getCodigoInteresFk(), $intereses);
                    $intereses[$indice] = false;
                    continue;
                }
                $em->remove($arInteresJugador);
            }
            # Guardamos los nuevos elementos
            foreach($intereses as $codigoInteres) {
                if($codigoInteres === false) continue;
                $arInteres = $em->getRepository(Interes::class)->find($codigoInteres);
                if(!$arInteres || !$arInteres instanceof Interes) continue;
                $arInteresJugador = new InteresJugador();
                $arInteresJugador->setJugadorRel($arJugador);
                $arInteresJugador->setInteresRel($arInteres);
                $em->persist($arInteresJugador);
            }
            $em->flush();
            return true;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}
