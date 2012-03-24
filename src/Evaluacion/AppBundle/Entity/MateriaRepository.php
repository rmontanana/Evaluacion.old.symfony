<?php
/* ***************************************************************************
 * AppBundle/Entity/MateriaRepository
 * Controlador para gestionar las competencias
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

class MateriaRepository extends EntityRepository
{
    /**
     * Encuentra todos los indicadores de una materia ordenados por Unidad
     * @param Materia $materia
     * @return array Evaluacion\Appbundle\Indicador
     */ /*i.id as id, i.descripcion as indicador, 
                        i.minimo as minimo, i.competencia*/
    public function findIndicadoresByMateria(Materia $materia, $competencia)
    {   
        $em = $this->getEntityManager();
        $dql = "SELECT  u.descripcion as unidad, i
                                               
                FROM    AppBundle:Indicador i
                JOIN    i.unidad u
                WHERE   u.materia = :materia 
                ORDER BY i.id" ;
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('materia', $materia);
        /* $consulta->setParameter('competencia', $competencia);
         * AND
                        i.competencia is null or i.competencia = :competencia
         */
        $indicadores = $consulta->getResult();
        return $indicadores;
    }
}

