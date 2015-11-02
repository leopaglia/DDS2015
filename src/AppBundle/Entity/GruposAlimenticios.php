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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Usuario", inversedBy="idGrupoalim")
     * @ORM\JoinTable(name="grupoalim_usuario",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_grupoalim", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dni", referencedColumnName="id")
     *   }
     * )
     */
    private $dni;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Dieta", inversedBy="idGrupo")
     * @ORM\JoinTable(name="grupoalim_dieta",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_grupo", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_dieta", referencedColumnName="id")
     *   }
     * )
     */
    private $idDieta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CondicionesDeSalud", inversedBy="idGrupo")
     * @ORM\JoinTable(name="grupoalim_condiciones",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_grupo", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_condicion", referencedColumnName="id")
     *   }
     * )
     */
    private $idCondicion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dni = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDieta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idCondicion = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add dni
     *
     * @param \AppBundle\Entity\Usuario $dni
     * @return GruposAlimenticios
     */
    public function addDni(\AppBundle\Entity\Usuario $dni)
    {
        $this->dni[] = $dni;

        return $this;
    }

    /**
     * Remove dni
     *
     * @param \AppBundle\Entity\Usuario $dni
     */
    public function removeDni(\AppBundle\Entity\Usuario $dni)
    {
        $this->dni->removeElement($dni);
    }

    /**
     * Get dni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Add idDieta
     *
     * @param \AppBundle\Entity\Dieta $idDieta
     * @return GruposAlimenticios
     */
    public function addIdDietum(\AppBundle\Entity\Dieta $idDieta)
    {
        $this->idDieta[] = $idDieta;

        return $this;
    }

    /**
     * Remove idDieta
     *
     * @param \AppBundle\Entity\Dieta $idDieta
     */
    public function removeIdDietum(\AppBundle\Entity\Dieta $idDieta)
    {
        $this->idDieta->removeElement($idDieta);
    }

    /**
     * Get idDieta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdDieta()
    {
        return $this->idDieta;
    }

    /**
     * Add idCondicion
     *
     * @param \AppBundle\Entity\CondicionesDeSalud $idCondicion
     * @return GruposAlimenticios
     */
    public function addIdCondicion(\AppBundle\Entity\CondicionesDeSalud $idCondicion)
    {
        $this->idCondicion[] = $idCondicion;

        return $this;
    }

    /**
     * Remove idCondicion
     *
     * @param \AppBundle\Entity\CondicionesDeSalud $idCondicion
     */
    public function removeIdCondicion(\AppBundle\Entity\CondicionesDeSalud $idCondicion)
    {
        $this->idCondicion->removeElement($idCondicion);
    }

    /**
     * Get idCondicion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdCondicion()
    {
        return $this->idCondicion;
    }
}
