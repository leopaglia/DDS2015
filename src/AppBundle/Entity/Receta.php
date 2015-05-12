<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Receta
 *
 * @ORM\Table(name="receta", indexes={@ORM\Index(name="temporadaFK_idx", columns={"temporada"})})
 * @ORM\Entity
 */
class Receta
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
     * @ORM\Column(name="dificultad", type="integer", nullable=true)
     */
    private $dificultad;

    /**
     * @var integer
     *
     * @ORM\Column(name="fotos", type="integer", nullable=true)
     */
    private $fotos;

    /**
     * @var string
     *
     * @ORM\Column(name="procedimiento", type="string", length=45, nullable=true)
     */
    private $procedimiento;

    /**
     * @var \AppBundle\Entity\Temporada
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Temporada")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="temporada", referencedColumnName="id")
     * })
     */
    private $temporada;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Condimento", inversedBy="idreceta")
     * @ORM\JoinTable(name="condimento_receta",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idReceta", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idCondimento", referencedColumnName="id")
     *   }
     * )
     */
    private $idcondimento;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ingrediente", inversedBy="idreceta")
     * @ORM\JoinTable(name="ingrediente_receta",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idReceta", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idIngrediente", referencedColumnName="id")
     *   }
     * )
     */
    private $idingrediente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcondimento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idingrediente = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Receta
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
     * Set dificultad
     *
     * @param integer $dificultad
     * @return Receta
     */
    public function setDificultad($dificultad)
    {
        $this->dificultad = $dificultad;

        return $this;
    }

    /**
     * Get dificultad
     *
     * @return integer 
     */
    public function getDificultad()
    {
        return $this->dificultad;
    }

    /**
     * Set fotos
     *
     * @param integer $fotos
     * @return Receta
     */
    public function setFotos($fotos)
    {
        $this->fotos = $fotos;

        return $this;
    }

    /**
     * Get fotos
     *
     * @return integer 
     */
    public function getFotos()
    {
        return $this->fotos;
    }

    /**
     * Set procedimiento
     *
     * @param string $procedimiento
     * @return Receta
     */
    public function setProcedimiento($procedimiento)
    {
        $this->procedimiento = $procedimiento;

        return $this;
    }

    /**
     * Get procedimiento
     *
     * @return string 
     */
    public function getProcedimiento()
    {
        return $this->procedimiento;
    }

    /**
     * Set temporada
     *
     * @param \AppBundle\Entity\Temporada $temporada
     * @return Receta
     */
    public function setTemporada(\AppBundle\Entity\Temporada $temporada = null)
    {
        $this->temporada = $temporada;

        return $this;
    }

    /**
     * Get temporada
     *
     * @return \AppBundle\Entity\Temporada 
     */
    public function getTemporada()
    {
        return $this->temporada;
    }

    /**
     * Add condimento
     *
     * @param \AppBundle\Entity\Condimento $idcondimento
     * @return Receta
     */
    public function addCondimento(\AppBundle\Entity\Condimento $idcondimento)
    {
        $this->idcondimento[] = $idcondimento;

        return $this;
    }

    /**
     * Remove condimento
     *
     * @param \AppBundle\Entity\Condimento $idcondimento
     */
    public function removeCondimento(\AppBundle\Entity\Condimento $idcondimento)
    {
        $this->idcondimento->removeElement($idcondimento);
    }

    /**
     * Get condimento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondimentos()
    {
        return $this->idcondimento;
    }

    /**
     * Add ingrediente
     *
     * @param \AppBundle\Entity\Ingrediente $idingrediente
     * @return Receta
     */
    public function addIngrediente(\AppBundle\Entity\Ingrediente $idingrediente)
    {
        $this->idingrediente[] = $idingrediente;

        return $this;
    }

    /**
     * Remove ingrediente
     *
     * @param \AppBundle\Entity\Ingrediente $idingrediente
     */
    public function removeIngrediente(\AppBundle\Entity\Ingrediente $idingrediente)
    {
        $this->idingrediente->removeElement($idingrediente);
    }

    /**
     * Get ingrediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredientes()
    {
        return $this->idingrediente;
    }
}
