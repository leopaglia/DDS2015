<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingrediente
 *
 * @ORM\Table(name="ingrediente")
 * @ORM\Entity
 */
class Ingrediente
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="porcion", type="integer", nullable=true)
     */
    private $porcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="calorias_porcion", type="integer", nullable=true)
     */
    private $caloriasPorcion;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=45, nullable=true)
     */
    private $unidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Receta", mappedBy="idingrediente")
     */
    private $idreceta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idreceta = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Ingrediente
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
     * Set porcion
     *
     * @param integer $porcion
     * @return Ingrediente
     */
    public function setPorcion($porcion)
    {
        $this->porcion = $porcion;

        return $this;
    }

    /**
     * Get porcion
     *
     * @return integer 
     */
    public function getPorcion()
    {
        return $this->porcion;
    }

    /**
     * Set caloriasPorcion
     *
     * @param integer $caloriasPorcion
     * @return Ingrediente
     */
    public function setCaloriasPorcion($caloriasPorcion)
    {
        $this->caloriasPorcion = $caloriasPorcion;

        return $this;
    }

    /**
     * Get caloriasPorcion
     *
     * @return integer 
     */
    public function getCaloriasPorcion()
    {
        return $this->caloriasPorcion;
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     * @return Ingrediente
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string 
     */
    public function getUnidad()
    {
        return $this->unidad;
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

    /**
     * Add idreceta
     *
     * @param \AppBundle\Entity\Receta $idreceta
     * @return Ingrediente
     */
    public function addIdrecetum(\AppBundle\Entity\Receta $idreceta)
    {
        $this->idreceta[] = $idreceta;

        return $this;
    }

    /**
     * Remove idreceta
     *
     * @param \AppBundle\Entity\Receta $idreceta
     */
    public function removeIdrecetum(\AppBundle\Entity\Receta $idreceta)
    {
        $this->idreceta->removeElement($idreceta);
    }

    /**
     * Get idreceta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdreceta()
    {
        return $this->idreceta;
    }
}
