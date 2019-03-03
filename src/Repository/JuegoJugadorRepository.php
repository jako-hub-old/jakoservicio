<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\JuegoJugador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JuegoJugadorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JuegoJugador::class);
    }

}
