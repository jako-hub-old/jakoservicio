<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\JuegoDetalle;
use App\Entity\JuegoEquipo;
use App\Entity\Posicion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JuegoEquipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JuegoEquipo::class);
    }

}
