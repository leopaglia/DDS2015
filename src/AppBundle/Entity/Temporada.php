<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Temporada
 *
 * @ORM\Table(name="temporada")
 * @ORM\Entity
 */
class Temporada
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
     * @var integer
     *
     * @ORM\Column(name="evento_social", type="integer", nullable=true)
     */
    private $eventoSocial;



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
     * @return Temporada
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
     * Set eventoSocial
     *
     * @param integer $eventoSocial
     * @return Temporada
     */
    public function setEventoSocial($eventoSocial)
    {
        $this->eventoSocial = $eventoSocial;

        return $this;
    }

    /**
     * Get eventoSocial
     *
     * @return integer 
     */
    public function getEventoSocial()
    {
        return $this->eventoSocial;
    }
}
