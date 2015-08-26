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
     * @ORM\Column(name="calificacion", type="integer", nullable=true)
     */
    private $calificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="paso1", type="string", length=255, nullable=false)
     */
    private $paso1;

    /**
     * @var string
     *
     * @ORM\Column(name="paso2", type="string", length=255, nullable=true)
     */
    private $paso2;

    /**
     * @var string
     *
     * @ORM\Column(name="paso3", type="string", length=255, nullable=true)
     */
    private $paso3;

    /**
     * @var string
     *
     * @ORM\Column(name="paso4", type="string", length=255, nullable=true)
     */
    private $paso4;

    /**
     * @var string
     *
     * @ORM\Column(name="paso5", type="string", length=255, nullable=true)
     */
    private $paso5;

    /**
     * @var string
     *
     * @ORM\Column(name="foto1", type="string", length=255, nullable=true)
     */
    private $foto1;

    /**
     * @var string
     *
     * @ORM\Column(name="foto2", type="string", length=255, nullable=true)
     */
    private $foto2;

    /**
     * @var string
     *
     * @ORM\Column(name="foto3", type="string", length=255, nullable=true)
     */
    private $foto3;

    /**
     * @var string
     *
     * @ORM\Column(name="foto4", type="string", length=255, nullable=true)
     */
    private $foto4;

    /**
     * @var string
     *
     * @ORM\Column(name="foto5", type="string", length=255, nullable=true)
     */
    private $foto5;

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
        $this->idusuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcondimento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idingrediente = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set paso1
     *
     * @param string $paso1
     * @return Receta
     */
    public function setPaso1($paso1)
    {
        $this->paso1 = $paso1;

        return $this;
    }

    /**
     * Get paso1
     *
     * @return string 
     */
    public function getPaso1()
    {
        return $this->paso1;
    }

    /**
     * Set paso2
     *
     * @param string $paso2
     * @return Receta
     */
    public function setPaso2($paso2)
    {
        $this->paso2 = $paso2;

        return $this;
    }

    /**
     * Get paso2
     *
     * @return string 
     */
    public function getPaso2()
    {
        return $this->paso2;
    }

    /**
     * Set paso3
     *
     * @param string $paso3
     * @return Receta
     */
    public function setPaso3($paso3)
    {
        $this->paso3 = $paso3;

        return $this;
    }

    /**
     * Get paso3
     *
     * @return string 
     */
    public function getPaso3()
    {
        return $this->paso3;
    }

    /**
     * Set paso4
     *
     * @param string $paso4
     * @return Receta
     */
    public function setPaso4($paso4)
    {
        $this->paso4 = $paso4;

        return $this;
    }

    /**
     * Get paso4
     *
     * @return string 
     */
    public function getPaso4()
    {
        return $this->paso4;
    }

    /**
     * Set paso5
     *
     * @param string $paso5
     * @return Receta
     */
    public function setPaso5($paso5)
    {
        $this->paso5 = $paso5;

        return $this;
    }

    /**
     * Get paso5
     *
     * @return string 
     */
    public function getPaso5()
    {
        return $this->paso5;
    }

    /**
     * Set foto1
     *
     * @param string $foto1
     * @return Receta
     */
    public function setFoto1($foto1)
    {
        $this->foto1 = $foto1;

        return $this;
    }

    /**
     * Get foto1
     *
     * @return string 
     */
    public function getFoto1()
    {
        return $this->foto1;
    }

    /**
     * Set foto2
     *
     * @param string $foto2
     * @return Receta
     */
    public function setFoto2($foto2)
    {
        $this->foto2 = $foto2;

        return $this;
    }

    /**
     * Get foto2
     *
     * @return string 
     */
    public function getFoto2()
    {
        return $this->foto2;
    }

    /**
     * Set foto3
     *
     * @param string $foto3
     * @return Receta
     */
    public function setFoto3($foto3)
    {
        $this->foto3 = $foto3;

        return $this;
    }

    /**
     * Get foto3
     *
     * @return string 
     */
    public function getFoto3()
    {
        return $this->foto3;
    }

    /**
     * Set foto4
     *
     * @param string $foto4
     * @return Receta
     */
    public function setFoto4($foto4)
    {
        $this->foto4 = $foto4;

        return $this;
    }

    /**
     * Get foto4
     *
     * @return string 
     */
    public function getFoto4()
    {
        return $this->foto4;
    }

    /**
     * Set foto5
     *
     * @param string $foto5
     * @return Receta
     */
    public function setFoto5($foto5)
    {
        $this->foto5 = $foto5;

        return $this;
    }

    /**
     * Get foto5
     *
     * @return string 
     */
    public function getFoto5()
    {
        return $this->foto5;
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
}
