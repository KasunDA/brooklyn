<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

//require the Router
require_once(realpath(dirname(__FILE__) . '/router.php'));

/**
 * Autoloader
 *
 * @param string $class_name
 */
function ahm_autoload($class_name){
    $chunk = explode('_', $class_name);
    if (array_shift($chunk) == 'AHM'){
        $chunk[count($chunk) - 1] = strtolower(end($chunk));
        $filename = dirname(__FILE__) . '/../' . implode('/', $chunk) . '.php';
        require_once(realpath($filename));
    }
}
//register autoload function
spl_autoload_register('ahm_autoload');

//require handler class. It is not included automatically
require_once(realpath(dirname(__FILE__) . '/../Error/Model/handler.php'));