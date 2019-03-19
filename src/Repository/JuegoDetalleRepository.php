<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\JuegoDetalle;
use App\Entity\Posicion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JuegoDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JuegoDetalle::class);
    }

}
