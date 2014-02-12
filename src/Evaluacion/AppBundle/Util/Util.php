<?php

/* * **************************************************************************
 * AppBundle/Util/Util.php
 * Clase Util donde realizan diversas acciones
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

namespace Evaluacion\AppBundle\Util;

use Symfony\Component\Yaml\Parser;

Class Util {

    /**
     * Devuelve el menú de la aplicación
     * @return string
     */
    static public function getMenu() {
        // Carga el fichero de configuración donde reside el menú
        $configuracion = __DIR__ . "/../Resources/config/menu.yml";
        $yaml = new Parser();
        // Llama al parser de symfony para que devuelva un array con el menú
        $menu = $yaml->parse(file_get_contents($configuracion));
        return $menu;
    }

    static public function getSlug($cadena, $separador = '-') {
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separador));
        $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
        return $slug;
    }
}

