<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

define('AHM_LOADED', 1);

//plugin directory name
define('AHM_BASEDIR', dirname(__FILE__));

//init core environment
require_once(realpath(dirname(__FILE__) . '/application/Core/bootstrap.php'));

//init Error Handling
Router::call('Error.init');