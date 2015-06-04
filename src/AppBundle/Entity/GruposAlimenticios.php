<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GruposAlimenticios
 *
 * @ORM\Table(name="grupos_alimenticios")
 * @ORM\Entity
 */
class GruposAlimenticios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="contraindicaciones", type="integer", nullable=true)
     */
    private $contraindicaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=45, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set contraindicaciones
     *
     * @param integer $contraindicaciones
     * @return GruposAlimenticios
     */
    public function setContraindicaciones($contraindicaciones)
    {
        $this->contraindicaciones = $contraindicaciones;

        return $this;
    }

    /**
     * Get contraindicaciones
     *
     * @return integer 
     */
    public function getContraindicaciones()
    {
        return $this->contraindicaciones;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return GruposAlimenticios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return GruposAlimenticios
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
