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
            return [
                'codigo_comentario' => $arComentario->getCodigoComentarioPk(),
                'guardado'          => true,
                'fecha'             => $arComentario->getFecha(),
                'jugador'           => $arJugador->getSeudonimo(),
                'foto_usuario'      => "https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1",
                'codigo_jugador'    => $arJugador->getCodigoJugadorPk(),
            ];
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function listar($datos)
    {
        $juego = $datos['juego'] ?? '';
        $em = $this->getEntityManager();
        $fotoUsuarioTemporal = "https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1";
        if ($juego) {
            $qb = $em->createQueryBuilder();
            $qb->from(Comentario::class, "c")
                ->select("c.codigoComentarioPk as codigo_comentario")
                ->addSelect("c.fecha")
                ->addSelect("c.comentario")
                ->addSelect("j.seudonimo as jugador")
                ->addSelect("'{$fotoUsuarioTemporal}' as foto_usuario")
                ->addSelect("c.codigoJuegoFk as codigo_jugador")
                ->leftJoin("c.jugadorRel", "j")
                ->where("c.codigoJuegoFk = '{$juego}'");
            return $qb->getQuery()->getResult();
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}
