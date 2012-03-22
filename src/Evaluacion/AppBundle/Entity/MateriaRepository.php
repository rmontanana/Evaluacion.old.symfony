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
use Evaluacion\AppBundle\Materia;
use Evaluacion\AppBundle\Indicador;

class MateriaRepository extends EntityRepository
{
    /**
     * Encuentra todos los indicadores de una materia ordenados por Unidad
     * @param Materia $materia
     * @return array Evaluacion\Appbundle\Indicador
     */
    public function findIndicadoresByMateria(Materia $materia)
    {   
        $em = $this->getEntityManager();
        $dql = 
        return $indicadores;
    }
}
?>
