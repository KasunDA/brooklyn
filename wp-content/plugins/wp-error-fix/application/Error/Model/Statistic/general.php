<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Error General Statistics Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/18/2012
 */
class AHM_Error_Model_Statistic_General {
    /**
     * Group Type - TYPE
     */

    const GROUP_TYPE = 'type';

    /**
     * Group Type - STATUS
     */
    const GROUP_STATUS = 'status';

    /**
     * Group Type - MODULE
     */
    const GROUP_MODULE = 'module';

    /**
     * Storage for list of errors
     *
     * @access protected
     * @var array
     */
    protected $_storage = NULL;

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
     * Handle the request
     *
     * @access public
     * @return array
     */
    public function run() {
        if (is_null($this->_storage)) { //scan only once per HTTP request
            $this->prepare();
        }

        return $this->_storage;
    }

    /**
     * Prepare Statistic
     *
     * @access protected
     */
    protected function prepare() {
        $this->reset();
        $_hash = array();
        foreach (Router::call('Error.errors') as $storage) {
            foreach ($storage as $hash => $data) {
                if (!in_array($hash, $_hash)) {
                    $this->incStat(self::GROUP_TYPE, $data['type']);
                    $this->incStat(self::GROUP_STATUS, ucfirst($data['status']));
                    $this->incStat(self::GROUP_MODULE, $data['module']);
                    $_hash[] = $hash;
                }
            }
        }
    }

    /**
     * Reset Statistic
     *
     * @access protected
     */
    protected function reset() {
        $this->_storage = array(
            self::GROUP_TYPE => array(),
            self::GROUP_STATUS => array(),
            self::GROUP_MODULE => array()
        );
    }

    /**
     * Increment Statistic value based on $group & $type
     *
     * @access protected
     * @param string $group
     * @param string $type
     * @param int $value
     */
    protected function incStat($group, $type, $value = 1) {
        if (!isset($this->_storage[$group][$type])) {
            $this->_storage[$group][$type] = 0;
        }
        $this->_storage[$group][$type] += $value;
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