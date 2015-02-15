<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * View Controller
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/15/2012
 */
class AHM_View_Controller {

    /**
     * Render Headers to HTML
     *
     * @access public
     * @param string $type
     * @return string
     */
    public function header($type) {
        $model = AHM_View_Model_Header::getInstance($type);

        return $model->handle();
    }

    /**
     * Retrieve View based on $view
     *
     * @access public
     * @param type $view
     * @return type
     */
    public function retrieveView($view) {
        $className = 'AHM_View_Model_View_' . ucfirst($view);
        $model = new $className();

        return $model->handle();
    }

}