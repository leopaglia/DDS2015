<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 */
class Usuario extends Model\User
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->idGrupoalim = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcondiciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idgrupo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="sexo", type="boolean", nullable=true)
     */
    private $sexo;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=true)
     */
    private $edad;

    /**
     * @var integer
     *
     * @ORM\Column(name="altura", type="integer", nullable=true)
     */
    private $altura;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=45, nullable=true)
     */
    private $apellido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultima_actualizacion", type="datetime", nullable=true)
     */
    private $ultimaActualizacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="dni", type="integer")
     */
    private $dni;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\Complexion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Complexion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="complexion", referencedColumnName="id")
     * })
     */
    private $complexion;

    /**
     * @var \AppBundle\Entity\GruposAlimenticios
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GruposAlimenticios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="preferencias", referencedColumnName="id")
     * })
     */
    private $preferencias;

    /**
     * @var \AppBundle\Entity\Rutina
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rutina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rutina", referencedColumnName="id")
     * })
     */
    private $rutina;

    /**
     * @var \AppBundle\Entity\Dieta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dieta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dieta", referencedColumnName="id")
     * })
     */
    private $dieta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\GruposAlimenticios", mappedBy="dni")
     */
    private $idGrupoalim;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CondicionesDeSalud", mappedBy="idusuario")
     */
    private $idcondiciones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Grupo", mappedBy="idusuario")
     */
    private $idgrupo;


//    /**
//     * Set username
//     *
//     * @param string $username
//     * @return Usuario
//     */
//    public function setUsername($username)
//    {
//        $this->username = $username;
//
//        return $this;
//    }

//    /**
//     * Get username
//     *
//     * @return string
//     */
//    public function getUsername()
//    {
//        return $this->username;
//    }

    /**
     * Set sexo
     *
     * @param boolean $sexo
     * @return Usuario
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return boolean 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Usuario
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set altura
     *
     * @param integer $altura
     * @return Usuario
     */
    public function setAltura($altura)
    {
        $this->altura = $altura;

        return $this;
    }

    /**
     * Get altura
     *
     * @return integer 
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set ultimaActualizacion
     *
     * @param \DateTime $ultimaActualizacion
     * @return Usuario
     */
    public function setUltimaActualizacion($ultimaActualizacion)
    {
        $this->ultimaActualizacion = $ultimaActualizacion;

        return $this;
    }

    /**
     * Get ultimaActualizacion
     *
     * @return \DateTime 
     */
    public function getUltimaActualizacion()
    {
        return $this->ultimaActualizacion;
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set complexion
     *
     * @param \AppBundle\Entity\Complexion $complexion
     * @return Usuario
     */
    public function setComplexion(\AppBundle\Entity\Complexion $complexion = null)
    {
        $this->complexion = $complexion;

        return $this;
    }

    /**
     * Get complexion
     *
     * @return \AppBundle\Entity\Complexion 
     */
    public function getComplexion()
    {
        return $this->complexion;
    }

    /**
     * Set preferencias
     *
     * @param \AppBundle\Entity\GruposAlimenticios $preferencias
     * @return Usuario
     */
    public function setPreferencias(\AppBundle\Entity\GruposAlimenticios $preferencias = null)
    {
        $this->preferencias = $preferencias;

        return $this;
    }

    /**
     * Get preferencias
     *
     * @return \AppBundle\Entity\GruposAlimenticios 
     */
    public function getPreferencias()
    {
        return $this->preferencias;
    }

    /**
     * Set rutina
     *
     * @param \AppBundle\Entity\Rutina $rutina
     * @return Usuario
     */
    public function setRutina(\AppBundle\Entity\Rutina $rutina = null)
    {
        $this->rutina = $rutina;

        return $this;
    }

    /**
     * Get rutina
     *
     * @return \AppBundle\Entity\Rutina 
     */
    public function getRutina()
    {
        return $this->rutina;
    }

    /**
     * Set dieta
     *
     * @param \AppBundle\Entity\Dieta $dieta
     * @return Usuario
     */
    public function setDieta(\AppBundle\Entity\Dieta $dieta = null)
    {
        $this->dieta = $dieta;

        return $this;
    }

    /**
     * Get dieta
     *
     * @return \AppBundle\Entity\Dieta 
     */
    public function getDieta()
    {
        return $this->dieta;
    }

    /**
     * Add idGrupoalim
     *
     * @param \AppBundle\Entity\GruposAlimenticios $idGrupoalim
     * @return Usuario
     */
    public function addIdGrupoalim(\AppBundle\Entity\GruposAlimenticios $idGrupoalim)
    {
        $this->idGrupoalim[] = $idGrupoalim;

        return $this;
    }

    /**
     * Remove idGrupoalim
     *
     * @param \AppBundle\Entity\GruposAlimenticios $idGrupoalim
     */
    public function removeIdGrupoalim(\AppBundle\Entity\GruposAlimenticios $idGrupoalim)
    {
        $this->idGrupoalim->removeElement($idGrupoalim);
    }

    /**
     * Get idGrupoalim
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdGrupoalim()
    {
        return $this->idGrupoalim;
    }

    /**
     * Add idcondiciones
     *
     * @param \AppBundle\Entity\CondicionesDeSalud $idcondiciones
     * @return Usuario
     */
    public function addIdcondicione(\AppBundle\Entity\CondicionesDeSalud $idcondiciones)
    {
        $this->idcondiciones[] = $idcondiciones;

        return $this;
    }

    /**
     * Remove idcondiciones
     *
     * @param \AppBundle\Entity\CondicionesDeSalud $idcondiciones
     */
    public function removeIdcondicione(\AppBundle\Entity\CondicionesDeSalud $idcondiciones)
    {
        $this->idcondiciones->removeElement($idcondiciones);
    }

    /**
     * Get idcondiciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcondiciones()
    {
        return $this->idcondiciones;
    }

    /**
     * Add idgrupo
     *
     * @param \AppBundle\Entity\Grupo $idgrupo
     * @return Usuario
     */
    public function addIdgrupo(\AppBundle\Entity\Grupo $idgrupo)
    {
        $this->idgrupo[] = $idgrupo;

        return $this;
    }

    /**
     * Remove idgrupo
     *
     * @param \AppBundle\Entity\Grupo $idgrupo
     */
    public function removeIdgrupo(\AppBundle\Entity\Grupo $idgrupo)
    {
        $this->idgrupo->removeElement($idgrupo);
    }

    /**
     * Get idgrupo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdgrupo()
    {
        return $this->idgrupo;
    }
}
