<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clasificacion
 *
 * @ORM\Table(name="clasificacion")
 * @ORM\Entity
 */
class Clasificacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=45, nullable=false)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Receta", inversedBy="idClasificacion")
     * @ORM\JoinTable(name="clasificacion_receta",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_clasificacion", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_receta", referencedColumnName="id")
     *   }
     * )
     */
    private $idReceta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idReceta = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Clasificacion
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

    /**
     * Add idReceta
     *
     * @param \AppBundle\Entity\Receta $idReceta
     * @return Clasificacion
     */
    public function addIdRecetum(\AppBundle\Entity\Receta $idReceta)
    {
        $this->idReceta[] = $idReceta;

        return $this;
    }

    /**
     * Remove idReceta
     *
     * @param \AppBundle\Entity\Receta $idReceta
     */
    public function removeIdRecetum(\AppBundle\Entity\Receta $idReceta)
    {
        $this->idReceta->removeElement($idReceta);
    }

    /**
     * Get idReceta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdReceta()
    {
        return $this->idReceta;
    }
}
