<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

//define global constants
//get URL to public files
$rel_path = str_replace(
        Router::call('Factory.absPath'),
        '',
        str_replace('\\', '/', dirname(__FILE__))
);
$base_url = Router::call('Factory.baseURL') . $rel_path;

define('AHM_VIEW_JSURL', $base_url . '/View/js');
define('AHM_VIEW_CSSURL', $base_url . '/View/css');
define('AHM_VIEW_TMPLDIR', realpath(dirname(__FILE__) . '/View/tmpl'));

return new AHM_View_Controller;