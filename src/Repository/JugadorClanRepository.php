<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Clan;
use App\Entity\JuegoTipo;
use App\Entity\Jugador;
use App\Entity\JugadorClan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JugadorClan|null find($id, $lockMode = null, $lockVersion = null)
 * @method JugadorClan|null findOneBy(array $criteria, array $orderBy = null)
 * @method JugadorClan[]    findAll()
 * @method JugadorClan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JugadorClanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JugadorClan::class);
    }

    /**
     * Listar los jugadores por clan
     * @param $raw
     * @return array|mixed
     */
    public function jugadoresClan($raw){
        $clan = $raw['clan']??null;

        if($clan){
            $em         = $this->getEntityManager();
            $existeClan = $em->getRepository(Clan::class)->find($clan);
            if($existeClan){
                $qbMiembros = $em->createQueryBuilder();
                $qbMiembros->from(JugadorClan::class, "jc")
                    ->select("jc.codigoJugadorFk")
                    ->where("jc.codigoClanFk = '{$clan}'")
                    ->andWhere("jc.confirmado = 1")
                    ->andWhere("jc.invitacion = 0 OR jc.invitacion IS NULL");
                $qbJugadores = $em->createQueryBuilder()
                    ->from(Jugador::class, "j")
                    ->select("j.codigoJugadorPk as codigo_jugador")
                    ->addSelect("j.nombreCorto as jugador_nombre_corto")
                    ->addSelect("j.fotoMiniatura as jugador_foto")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->where("j.codigoJugadorPk IN ({$qbMiembros})");
                return $qbJugadores->getQuery()->getResult();
            } else{
                return [
                    'error_controlado' => Utilidades::validacion(14),
                ];
            }
        } else{
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}
