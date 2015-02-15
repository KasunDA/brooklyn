<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Ajax Controller
 *
 * @package WordPress\WP Error Fix\Ajax
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/14/2012
 */
class AHM_Ajax_Controller {

    /**
     * Process Ajax Request
     *
     * @return string JSON encoded result
     *
     * @access public
     */
    public function process() {
        Router::call('Factory.checkAjaxReferer'); //block access if not authorized
        $model = new AHM_Ajax_Model_Action;

        return $model->handle();
    }

}