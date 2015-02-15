<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Settings MySQL Model
 *
 * @package WordPress\WP Error Fix\Settings
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/13/2012
 */
class AHM_Settings_Model_Mysql implements AHM_Settings_Model_Interface {

    /**
     * Cache
     *
     * @access protected
     * @var array
     */
    protected $_cache = array();

    /**
     * Instance of itself
     *
     * @access protected
     * @var AHM_Settings_Model_Mysql
     */
    protected static $_instance;

    /**
     * @inheritdoc
     */
    public function read($param) {
        if (!isset($this->_cache[$param])) {
            $this->_cache[$param] = Router::call('Factory.getOption', $param);
        }

        return $this->_cache[$param];
    }

    /**
     * @inheritdoc
     */
    public function update($param, $value) {
        if ($result = Router::call('Factory.updateOption', $param, $value)){
            $this->_cache[$param] = $value;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function delete($param) {
        if (isset($this->_cache[$param])) {
            unset($this->_cache[$param]);
        }

        return Router::call('Factory.deleteOption', $param);
    }

    /**
     * Get Single instance of itself
     *
     * @access public
     * @return AHM_Settings_Model_Mysql
     */
    public static function getInstance(){
        if (is_null(self::$_instance)){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}