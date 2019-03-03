<?php

namespace App\Repository;

use App\Entity\JugadorAmigo;
use App\Entity\JugadorSolicitud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JugadorSolicitudRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JugadorSolicitud::class);
    }

}
