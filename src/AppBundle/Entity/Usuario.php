<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="complexionFK_idx", columns={"complexion"}), @ORM\Index(name="condicionSaludFK_idx", columns={"condicion"}), @ORM\Index(name="dietaFK_idx", columns={"dieta"}), @ORM\Index(name="rutinaFK_idx", columns={"rutina"}), @ORM\Index(name="preferenciasFK_idx", columns={"preferencias"})})
 * @ORM\Entity
 */
class Usuario implements UserInterface, \Serializable
{
	
	/**
	 * @ORM\Column(name="password", type="string", length=64)
	 */
	private $password;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="dni", type="integer")
     * @ORM\Id
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=true)
     */
    private $username;

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
     * @var \AppBundle\Entity\Complexion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Complexion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="complexion", referencedColumnName="id")
     * })
     */
    private $complexion;

    /**
     * @var \AppBundle\Entity\CondicionesDeSalud
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CondicionesDeSalud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="condicion", referencedColumnName="id")
     * })
     */
    private $condicion;

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
    
    
	public function __construct($dni, $user, $pass, $sexo, $edad){
		$this->username = $user;
		$this->dni = $dni;
		$this->password = md5($pass);
		$this->sexo = $sexo;
		$this->edad = $edad;
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
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

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
     * Set condicion
     *
     * @param \AppBundle\Entity\CondicionesDeSalud $condicion
     * @return Usuario
     */
    public function setCondicion(\AppBundle\Entity\CondicionesDeSalud $condicion = null)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return \AppBundle\Entity\CondicionesDeSalud 
     */
    public function getCondicion()
    {
        return $this->condicion;
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
    
    
    
    //INTERFACE METHODS

    public function getUsername()
    {
    	return $this->username;
    }
    
    public function getSalt()
    {
    	// you *may* need a real salt depending on your encoder
    	// see section on salt below
    	return null;
    }
    
    public function getPassword()
    {
    	return $this->password;
    }
    
    public function getRoles()
    {
    	return array('ROLE_USER');
    }
    
    public function eraseCredentials()
    {
    }
    
    
    
    public function serialize()
    {
    	return serialize(array(
    			$this->dni,
    			$this->username,
    			$this->password,
    			// see section on salt below
    			// $this->salt,
    	));
    }
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
    	list (
    			$this->dni,
    			$this->username,
    			$this->password,
    			// see section on salt below
    			// $this->salt
    	) = unserialize($serialized);
    }
}
