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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Usuario", inversedBy="idcondiciones")
     * @ORM\JoinTable(name="condiciones_usuario",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idCondiciones", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idUsuario", referencedColumnName="dni")
     *   }
     * )
     */
    private $idusuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idusuario = new \Doctrine\Common\Collections\ArrayCollection();
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
