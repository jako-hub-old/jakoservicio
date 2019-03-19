<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Comentario;
use App\Entity\Juego;
use App\Entity\Jugador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ComentarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comentario::class);
    }

    public function nuevo($datos) {
        $em = $this->getEntityManager();
        $juego = $datos['juego']?? '';
        $jugador = $datos['jugador']?? '';
        $comentario = $datos['comentario']?? '';
        if($juego && $jugador && $comentario) {
            $arJuego = $em->getRepository(Juego::class)->find($juego);
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            $arComentario = new Comentario();
            $arComentario->setJuegoRel($arJuego);
            $arComentario->setJugadorRel($arJugador);
            $arComentario->setComentario($comentario);
            $arComentario->setFecha(new \DateTime('now'));
            $em->persist($arComentario);
            $em->flush();
            return true;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}
