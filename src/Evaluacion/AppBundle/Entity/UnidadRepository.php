<?php
/* ***************************************************************************
 * AppBundle/Entity/UnidadRepository
 * Controlador para gestionar las Unidades didácticas
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
use Doctrine\ORM\EntityRepository;

class UnidadRepository extends EntityRepository
{
    public function setIndicadoresEvaluacion(Unidad $unidad, Evaluacion $evaluacion)
    {   
        // Para asignar/desasignar Indicadores a una Evaluación determinada
        // hay que hacer un bucle a partir de la unidad que vaya recorriendo todos sus indicadores y estableciendo 
        // la evaluación en la colección que guarda cada indicador.
        $em = $this->getEntityManager();
        //TODO Esto no funciona hay que hacer un método findIndicadoresByUnidad y buscar los indicadores de una unidad
        foreach($unidad->indicadores as $indicador) {
            if (isset($evaluacion)) {
                $indicador->addEvaluacion($evaluacion);
            } else {
                $indicador->removeEvaluacion($evaluacion);
            }
            $em->persist($indicador);
        }
        $em->flush();
    }
}

