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
    
}