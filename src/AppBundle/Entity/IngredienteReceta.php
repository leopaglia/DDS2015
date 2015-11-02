<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingrediente
 *
 * @ORM\Table(name="ingrediente_receta")
 * @ORM\Entity
 */
class IngredienteReceta
{

    /**
     * @var \AppBundle\Entity\Receta
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Receta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idreceta", referencedColumnName="id")
     * })
     */
    private $idreceta;

    /**
     * @var \AppBundle\Entity\Ingrediente
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ingrediente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idingrediente", referencedColumnName="id")
     * })
     */
    private $idingrediente;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * Set Receta
     *
     * @param \AppBundle\Entity\Receta $receta
     * @return IngredienteReceta
     */
    public function setReceta(\AppBundle\Entity\Receta $receta = null)
    {
        $this->idreceta = $receta;

        return $this;
    }

    /**
     * Get receta
     *
     * @return \AppBundle\Entity\Receta
     */
    public function getReceta()
    {
        return $this->idreceta;
    }

    /**
     * Set Ingrediente
     *
     * @param \AppBundle\Entity\Ingrediente $ingrediente
     * @return IngredienteReceta
     */
    public function setIngrediente(\AppBundle\Entity\Ingrediente $ingrediente = null)
    {
        $this->idingrediente = $ingrediente;

        return $this;
    }

    /**
     * Get Ingrediente
     *
     * @return \AppBundle\Entity\Ingrediente
     */
    public function getIngrediente()
    {
        return $this->idingrediente;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return IngredienteReceta
     */
    public function setcantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getcantidad()
    {
        return $this->cantidad;
    }
}
