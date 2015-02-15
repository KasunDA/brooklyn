<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Email Controller
 *
 * @package WordPress\WP Error Fix\Email
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 12/28/2013
 */
class AHM_Email_Controller {

    /**
     * Notify about errors occured in your system
     * 
     * @return void
     * 
     * @access public
     */
    public function notifyError() {
        $model = new AHM_Email_Model_Error();
        $model->send();
    }

    /**
     * Notify about available solution
     * 
     * @return void
     * 
     * @access public
     */
    public function notifySolution() {
        $model = new AHM_Email_Model_Solution();
        $model->send();
    }

}