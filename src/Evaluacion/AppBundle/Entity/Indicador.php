<?php
/* ***************************************************************************
 * AppBundle/Entity/Indicador
 * Entidad Indicador
 * (C) Copyright 2012 Ricardo Montañana <rmontanana@gmail.com>
 * This file is part of Evaluacion.
 * ***************************************************************************
 * Evaluacion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Evaluacion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Evaluacion (LICENSE file). 
 * If not, see <http://www.gnu.org/licenses/>
 * ***************************************************************************
 */
namespace Evaluacion\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evaluacion\AppBundle\Entity\Indicador
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Evaluacion\AppBundle\Entity\IndicadorRepository")
 */
class Indicador
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var text $descripcion
     *
     * @ORM\Column(name="descripcion", type="text")
     * @Assert\NotNull(message = "La descripción no puede estar vacía")
     */
    private $descripcion;

    /**
     * @var boolean $minimo
     *
     * @ORM\Column(name="minimo", type="boolean")
     */
    private $minimo = false;

    /**
     * @var text $competencia
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Competencia")
     */
    private $competencia;

    /**
     * @var text $criterioEvaluacion
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\CriterioEvaluacion")
     */
    private $criterioEvaluacion;
    
     /**
     * @var string $unidad
     * 
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Unidad")
     */
    private $unidad;
    
    /**
     * Evaluaciones en las que está evaluándose este indicador.
     * 
     * @var \Doctrine\Common\Collections\ArrrayCollections $evaluaciones
     * 
     * @ORM\ManyToMany(targetEntity="Evaluacion\AppBundle\Entity\Evaluacion", inversedBy="indicadores", cascade={"persist"})
     */
    private $evaluaciones;

    /**
     * Constructor
     * @return type \Evaluacion\AppBundle\Entity\Indicador
     */
    public function __construct()
    {
        $this->evaluaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcion
     *
     * @param text $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return text 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set minimo
     *
     * @param boolean $minimo
     */
    public function setMinimo($minimo)
    {
        $this->minimo = $minimo;
    }

    /**
     * Get minimo
     *
     * @return boolean 
     */
    public function getMinimo()
    {
        return $this->minimo;
    }

    /**
     * Set competencia
     *
     * @param \Evaluacion\AppBundle\Entity\Competencia $competencia
     */
    public function setCompetencia(\Evaluacion\AppBundle\Entity\Competencia $competencia = null)
    {
        $this->competencia = $competencia;
    }

    /**
     * Get competencia
     *
     * @return text 
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set criterioEvaluacion
     *
     * @param \Evaluacion\AppBundle\Entity\CriterioEvaluacion $criterioEvaluacion
     */
    public function setCriterioEvaluacion(\Evaluacion\AppBundle\Entity\CriterioEvaluacion $criterioEvaluacion)
    {
        $this->criterioEvaluacion = $criterioEvaluacion;
    }

    /**
     * Get criterioEvaluacion
     *
     * @return \Evaluacion\AppBundle\Entity\CriterioEvaluacion 
     */
    public function getCriterioEvaluacion()
    {
       return $this->criterioEvaluacion;
    }
    
     /**
     * Set unidad didáctica
     * 
     * @param \Evaluacion\AppBundle\Entity\Unidad $unidad 
     */
    public function setUnidad(\Evaluacion\AppBundle\Entity\Unidad $unidad)
    {
        $this->unidad = $unidad;
    }
    
    /**
     * Get unidad didáctica
     * 
     * @return Evaluacion\AppBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }
    
    /**
     * Devuelve la imagen de un Indicador
     * @return text
     */
    public function __toString()
    {
        return $this->descripcion;
    }
    
    /**
     * Add evaluaciones
     *
     * @param Evaluacion\AppBundle\Entity\Evaluacion $evaluacion
     * @return boolean
     */
    public function addEvaluacion(\Evaluacion\AppBundle\Entity\Evaluacion $evaluacion)
    {
        if (!$this->hasEvaluacion($evaluacion, false)) {
            $this->evaluaciones[] = $evaluacion;
            return true;
        }
        return false;
    }
    
    /**
     * Averigua si el indicador ya está definido en esa evaluación y puede borrarlo
     * 
     * @param Evaluacion\AppBundle\Entity\Evaluacion $evaluacion
     * @return boolean
     */
    public function hasEvaluacion(\Evaluacion\AppBundle\Entity\Evaluacion $evaluacion, $borrar = false)
    {
        foreach ($this->evaluaciones as $valor) {
            if ($valor->getId() == $evaluacion->getId()) {
                if ($borrar) {
                    $this->evaluaciones->removeElement($evaluacion);
                }
                return true;
            }
        }
        return false;
    }
    
    /**
     * Elimina una evaluación del indicador
     * 
     * @param Evaluacion\AppBundle\Entity\Evaluacion $evaluacion 
     */
    public function removeEvaluacion(\Evaluacion\AppBundle\Entity\Evaluacion $evaluacion)
    {
        if($this->hasEvaluacion($evaluacion,true)) {
            return true;
        }
        return false;
    }

    /**
     * Get evaluaciones
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getEvaluaciones()
    {
        return $this->evaluaciones;
    }
    
}