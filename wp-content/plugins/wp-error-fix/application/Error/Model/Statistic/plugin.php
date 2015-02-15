<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Error Statistics grouped by Plugin
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 02/25/2013
 */
class AHM_Error_Model_Statistic_Plugin {

    /**
     * Single instance of itself
     *
     * Is very importand to have only single instance to
     * avoid mismatch in error list
     *
     * @access protected
     * @var AHM_Error_Model_Statistic_General
     */
    protected static $_instance = NULL;

    /**
     * Grouped stats
     *
     * @var array
     *
     * @access private
     */
    private $_stats = array();

    /**
     * Handle the request
     *
     * @access public
     * @return array
     */
    public function run() {
        $this->prepare();

        return $this->_stats;
    }

    /**
     * Prepare Statistic
     *
     * @access protected
     */
    protected function prepare() {
        foreach (Router::call('Error.errors') as $storage) {
            foreach ($storage as $data) {
                if (!isset($this->_stats[$data['module']])) {
                    $this->_stats[$data['module']] = array(0, 0, 0);
                }
                if ($data['type'] == 'Error') {
                    $index = 0;
                } elseif ($data['type'] == 'Warning') {
                    $index = 1;
                } else {
                    $index = 2;
                }
                $this->_stats[$data['module']][$index]++;
            }
        }
    }

    /**
     * Get Single instance of itself
     *
     * @access public
     * @return AHM_Error_Model_Statistic_General
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}