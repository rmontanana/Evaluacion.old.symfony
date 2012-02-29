<?php
/* ***************************************************************************
 * AppBundle/Entity/AsignacionPeso
 * Entidad AsignacionPeso
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

/**
 * Evaluacion\AppBundle\Entity\AsignacionPeso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AsignacionPeso
{

    /**
     * @var text $criterioEvaluacion
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\CriterioEvaluacion")
     */
    private $criterioEvaluacion;

    /**
     * @var text $evaluacion
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Evaluacion")
     */
    private $evaluacion;

    /**
     * @var decimal $peso
     *
     * @ORM\Column(name="peso", type="decimal")
     */
    private $peso;


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
     * Set evaluacion
     *
     * @param \Evaluacion\AppBundle\Entity\Evaluacion $evaluacion
     */
    public function setEvaluacion(\Evaluacion\AppBundle\Entity\Evaluacion $evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    /**
     * Get evaluacion
     *
     * @return \Evaluacion\AppBundle\Entity\Evaluacion 
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    /**
     * Set peso
     *
     * @param decimal $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    /**
     * Get peso
     *
     * @return decimal 
     */
    public function getPeso()
    {
        return $this->peso;
    }
    
    /**
     * Devuelve la imagen de una asignacion de peso
     * @return decimal
     */
    public function __toString()
    {
        return $this->peso;
    }
}