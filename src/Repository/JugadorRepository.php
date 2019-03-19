<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Jugador;
use App\Entity\JugadorAmigo;
use App\Entity\JugadorSolicitud;
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
            ->addSelect("j.seudonimo");
        $arJugadores =  $qb->getQuery()->getResult();
        return $arJugadores;

    }

}
