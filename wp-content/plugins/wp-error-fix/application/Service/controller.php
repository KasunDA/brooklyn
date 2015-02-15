<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Service Controller
 *
 * @package WordPress\WP Error Fix\Service
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/15/2012
 */
class AHM_Service_Controller {

    /**
     * Current Service to work with
     *
     * @access protected
     * @var AHM_Service_Model_Interface
     */
    protected $_service = NULL;

    /**
     * @inheritdoc
     */
    public function __construct() {
        $this->_service = new AHM_Service_Model_Rest($this);
    }

    /**
     * Handle service call
     *
     * @access public
     * @param string $name
     * @param array $arguments
     * @return array
     */
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->_service, $name), $arguments);
    }

}