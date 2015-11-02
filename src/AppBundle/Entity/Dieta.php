<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dieta
 *
 * @ORM\Table(name="dieta")
 * @ORM\Entity
 */
class Dieta
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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\GruposAlimenticios", mappedBy="idDieta")
     */
    private $idGrupo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idGrupo = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Dieta
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add idGrupo
     *
     * @param \AppBundle\Entity\GruposAlimenticios $idGrupo
     * @return Dieta
     */
    public function addIdGrupo(\AppBundle\Entity\GruposAlimenticios $idGrupo)
    {
        $this->idGrupo[] = $idGrupo;

        return $this;
    }

    /**
     * Remove idGrupo
     *
     * @param \AppBundle\Entity\GruposAlimenticios $idGrupo
     */
    public function removeIdGrupo(\AppBundle\Entity\GruposAlimenticios $idGrupo)
    {
        $this->idGrupo->removeElement($idGrupo);
    }

    /**
     * Get idGrupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdGrupo()
    {
        return $this->idGrupo;
    }
}
