<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function lista($filtros)
    {
        $usuario = $filtros['usuario']?? false;
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->from(Usuario::class, "u")
            ->select("u.codigoUsuarioPk as codigo_usuario")
            ->addSelect("u.codigoJugadorFk as codigo_jugador")
            ->addSelect("u.seudonimo")
            ->addSelect("u.usuario")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->leftJoin("u.jugadorRel", "j");

        # Filtros
        if($usuario !== false) {
            $qb->andWhere("u.usuario = '{$usuario}'");
        }

        return $qb->getQuery()->getResult();
    }

    public function registrar($datos) {
        $em = $this->getEntityManager();
        $usuario = $datos['usuario']?? '';
        $clave = $datos['clave']?? '';
    }

    public function validarUsuarioExistente() {

    }

}
