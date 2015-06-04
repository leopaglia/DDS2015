<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Condimento
 *
 * @ORM\Table(name="condimento")
 * @ORM\Entity
 */
class Condimento
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
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Receta", mappedBy="idcondimento")
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
     * @return Condimento
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
     * Set tipo
     *
     * @param integer $tipo
     * @return Condimento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
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
     * @return Condimento
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
