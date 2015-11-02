<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CondicionesDeSalud
 *
 * @ORM\Table(name="condiciones_de_salud")
 * @ORM\Entity
 */
class CondicionesDeSalud
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\GruposAlimenticios", mappedBy="idCondicion")
     */
    private $idGrupo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Usuario", inversedBy="idcondiciones")
     * @ORM\JoinTable(name="condiciones_usuario",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idCondiciones", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idUsuario", referencedColumnName="id")
     *   }
     * )
     */
    private $idusuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idGrupo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idusuario = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return CondicionesDeSalud
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
     * @return CondicionesDeSalud
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

    /**
     * Add idusuario
     *
     * @param \AppBundle\Entity\Usuario $idusuario
     * @return CondicionesDeSalud
     */
    public function addIdusuario(\AppBundle\Entity\Usuario $idusuario)
    {
        $this->idusuario[] = $idusuario;

        return $this;
    }

    /**
     * Remove idusuario
     *
     * @param \AppBundle\Entity\Usuario $idusuario
     */
    public function removeIdusuario(\AppBundle\Entity\Usuario $idusuario)
    {
        $this->idusuario->removeElement($idusuario);
    }

    /**
     * Get idusuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}
