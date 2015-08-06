<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historial
 *
 * @ORM\Table(name="historial", indexes={@ORM\Index(name="FK_historial_receta_idx", columns={"idreceta"}), @ORM\Index(name="FK_historial_usuario_idx", columns={"idusuario"})})
 * @ORM\Entity
 */
class Historial
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="dni")
     * })
     */
    private $idusuario;

    /**
     * @var \AppBundle\Entity\Receta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Receta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idreceta", referencedColumnName="id")
     * })
     */
    private $idreceta;


    /**
     * @param \AppBundle\Entity\Usuario $user
     * @param \AppBundle\Entity\Receta $receta
     */
    public function __construct($user, $receta){

        $this->setIdusuario($user);
        $this->setIdreceta($receta);
        $this->setFecha(new \DateTime());

    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Historial
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
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
     * Set idusuario
     *
     * @param \AppBundle\Entity\Usuario $idusuario
     * @return Historial
     */
    public function setIdusuario(\AppBundle\Entity\Usuario $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set idreceta
     *
     * @param \AppBundle\Entity\Receta $idreceta
     * @return Historial
     */
    public function setIdreceta(\AppBundle\Entity\Receta $idreceta = null)
    {
        $this->idreceta = $idreceta;

        return $this;
    }

    /**
     * Get idreceta
     *
     * @return \AppBundle\Entity\Receta 
     */
    public function getIdreceta()
    {
        return $this->idreceta;
    }
}
