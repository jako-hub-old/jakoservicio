<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\Negocio;
use App\Entity\NegocioTipo;
use App\Entity\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NegocioTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NegocioTipo::class);
    }


}
