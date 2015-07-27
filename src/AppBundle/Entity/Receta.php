<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Receta
 *
 * @ORM\Table(name="receta", indexes={@ORM\Index(name="temporadaFK_idx", columns={"temporada"}), @ORM\Index(name="dificultadFK_idx", columns={"dificultad"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecetasRepository")
 */
class Receta
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
     * @var integer
     *
     * @ORM\Column(name="calificacion", type="integer", nullable=true)
     */
    private $calificacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Dificultad
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dificultad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dificultad", referencedColumnName="id")
     * })
     */
    private $dificultad;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Usuario", inversedBy="idreceta")
     * @ORM\JoinTable(name="receta_usuario",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idreceta", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idusuario", referencedColumnName="dni")
     *   }
     * )
     */
    private $idusuario;
	
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
     * Constructor
     */
    public function __construct()
    {
		$this->idusuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idingrediente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcondimento = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set calificacion
     *
     * @param integer $calificacion
     * @return Receta
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return integer 
     */
    public function getCalificacion()
    {
        return $this->calificacion;
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
     * Set dificultad
     *
     * @param \AppBundle\Entity\Dificultad $dificultad
     * @return Receta
     */
    public function setDificultad(\AppBundle\Entity\Dificultad $dificultad = null)
    {
        $this->dificultad = $dificultad;

        return $this;
    }

    /**
     * Get dificultad
     *
     * @return \AppBundle\Entity\Dificultad 
     */
    public function getDificultad()
    {
        return $this->dificultad;
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
     * Add idingrediente
     *
     * @param \AppBundle\Entity\Ingrediente $idingrediente
     * @return Receta
     */
    public function addIdingrediente(\AppBundle\Entity\Ingrediente $idingrediente)
    {
        $this->idingrediente[] = $idingrediente;

        return $this;
    }

    /**
     * Remove idingrediente
     *
     * @param \AppBundle\Entity\Ingrediente $idingrediente
     */
    public function removeIdingrediente(\AppBundle\Entity\Ingrediente $idingrediente)
    {
        $this->idingrediente->removeElement($idingrediente);
    }

    /**
     * Get idingrediente
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdingrediente()
    {
        return $this->idingrediente;
    }

	    /**
     * Add idusuario
     *
     * @param \AppBundle\Entity\Usuario $idusuario
     * @return Receta
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
	
    /**
     * Add idcondimento
     *
     * @param \AppBundle\Entity\Condimento $idcondimento
     * @return Receta
     */
    public function addIdcondimento(\AppBundle\Entity\Condimento $idcondimento)
    {
        $this->idcondimento[] = $idcondimento;

        return $this;
    }

    /**
     * Remove idcondimento
     *
     * @param \AppBundle\Entity\Condimento $idcondimento
     */
    public function removeIdcondimento(\AppBundle\Entity\Condimento $idcondimento)
    {
        $this->idcondimento->removeElement($idcondimento);
    }

    /**
     * Get idcondimento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcondimento()
    {
        return $this->idcondimento;
    }
}
