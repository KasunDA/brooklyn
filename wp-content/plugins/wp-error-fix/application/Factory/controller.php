<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Factory Controller
 *
 * @package WordPress\WP Error Fix\Factory
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/15/2012
 */
class AHM_Factory_Controller {

    /**
     * Current Factory to work with
     *
     * @access private
     * @var AHM_Factory_Model
     */
    private $_factory = NULL;

    /**
     * Call Factory function
     *
     * @access public
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        if (is_null($this->_factory)){
            $className = 'AHM_Factory_Model_' . AHM_FACTORY_FACTORY;
            $this->_factory = new $className;
        }

        return call_user_func_array(array($this->_factory, $name), $arguments);
    }

}