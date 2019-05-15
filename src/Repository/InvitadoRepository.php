<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Invitado;
use App\Entity\Jugador;
use App\Entity\JugadorAmigo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InvitadoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invitado::class);
    }

    public function getSugerenciasDeAmistad($data) {
        $jugador = $data['jugador']?? null;
        if($jugador) {
            $deMisInvitaciones = $this->sugerenciasDeMisInvitaciones($jugador);
            $losQueMeInvitan = $this->sugerenciasQuienesMeInvitaron($jugador);
            $amigosDeMisAmigos = $this->amigosDeMisAmigos($jugador);
            $sugerenciasPropuestas = array_merge($deMisInvitaciones, $losQueMeInvitan, $amigosDeMisAmigos);
            $sugerencias = [];
            $ids = [];
            # Con esto nos aseguramos que no haya sugerencias duplicadas.
            foreach($sugerenciasPropuestas as $sugerencia) {
                if(!in_array($sugerencia['codigo_jugador'], $ids)) {
                    $sugerencias[] = $sugerencia;
                    $ids[] = $sugerencia['codigo_jugador'];
                }
            }
            return $sugerencias;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    private function sugerenciasDeMisInvitaciones($jugador) {
        $em = $this->getEntityManager();
        $qbInvitaciones = $em->createQueryBuilder();
        $qbMisAmigos = $em->createQueryBuilder()
            ->from(JugadorAmigo::class, "ja")
            ->select("ja.codigoJugadorAmigoFk")
            ->where("ja.codigoJugadorFk = '{$jugador}'");

        $qbInvitaciones->from(Invitado::class, "i")
            ->select("i.telefonoInvitado")
            ->where("i.registrado = 1")
            ->andWhere("i.codigoJugadorFk = '{$jugador}'")
            ->andWhere("i.amigo = 0 OR i.amigo IS NULL");

        $qbSugerencias = $em->createQueryBuilder()
            ->from(Jugador::class, "j")
            ->select("j.codigoJugadorPk codigo_jugador")
            ->addSelect("j.fotoMiniatura as foto")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->addSelect("j.seudonimo as jugador_seudonimo")
            ->leftJoin("j.usuariosJugadorRel", "u")
            ->where("u.usuario IN ({$qbInvitaciones})")
            ->andWhere("j.codigoJugadorPk NOT IN ($qbMisAmigos)");
        return $qbSugerencias->getQuery()->getResult();
    }

    private function sugerenciasQuienesMeInvitaron($jugador) {
        $em = $this->getEntityManager();
        $qbInvitaciones = $em->createQueryBuilder();
        $arJugador = $em->getRepository(Jugador::class)->find($jugador);
        if(!$arJugador || !$arJugador instanceof  Jugador) {
            return [];
        }
        $qbMisAmigos = $em->createQueryBuilder()
            ->from(JugadorAmigo::class, "ja")
            ->select("ja.codigoJugadorAmigoFk")
            ->where("ja.codigoJugadorFk = '{$jugador}'");

        $telefono = $arJugador->getUsuariosJugadorRel()[0]->getUsuario();
        $qbInvitaciones->from(Invitado::class, "i")
            ->select("i.codigoJugadorFk")
            ->where("i.registrado = 1")
            ->andWhere("i.amigo = 0 OR i.amigo IS NULL")
            ->andWhere("i.telefonoInvitado = '{$telefono }'");

        $qbSugerencias = $em->createQueryBuilder()
            ->from(Jugador::class, "j")
            ->select("j.codigoJugadorPk codigo_jugador")
            ->addSelect("j.foto")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->addSelect("j.seudonimo as jugador_seudonimo")
            ->where("j.codigoJugadorPk IN ({$qbInvitaciones})")
            ->andWhere("j.codigoJugadorPk NOT IN ($qbMisAmigos)");
        return $qbSugerencias->getQuery()->getResult();
    }

    public function amigosDeMisAmigos($jugador) {
        $em = $this->getEntityManager();
        $qbMisAmigos = $em->createQueryBuilder()
            ->from(JugadorAmigo::class, "ja")
            ->select("ja.codigoJugadorAmigoFk")
            ->where("ja.codigoJugadorFk = '{$jugador}'");

        $qbMisAmigos2 = $em->createQueryBuilder()
            ->from(JugadorAmigo::class, "ja2")
            ->select("ja2.codigoJugadorAmigoFk")
            ->where("ja2.codigoJugadorFk = '{$jugador}'");

        $qbAmigosDeMisAmigos = $em->createQueryBuilder()
            ->from(JugadorAmigo::class, "ada")
            ->select("ada.codigoJugadorAmigoFk")
            ->where("ada.codigoJugadorAmigoFk <> '{$jugador}'")
            ->andWhere("ada.codigoJugadorFk IN ($qbMisAmigos)");

        $qbSugerencias = $em->createQueryBuilder()
            ->from(Jugador::class, "j")
            ->select("j.codigoJugadorPk codigo_jugador")
            ->addSelect("j.foto")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->addSelect("j.seudonimo as jugador_seudonimo")
            ->where("j.codigoJugadorPk IN ({$qbAmigosDeMisAmigos})")
            ->andWhere("j.codigoJugadorPk NOT IN ({$qbMisAmigos2})");
        return $qbSugerencias->getQuery()->getResult();
    }
}
