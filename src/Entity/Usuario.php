<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_usuario_pk",type="integer")
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(name="usuario", type="string",length=30, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="seudonimo", type="string",length=30, nullable=true)
     */
    private $seudonimo;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="usuariosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Juego", mappedBy="usuarioAdministradorRel")
     */
    protected $juegosUsuarioAdministradorRel;

}

