<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */


/**
 * Settings Storage Interface
 *
 * @package WordPress\WP Error Fix\Settings
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/13/2012
 */
interface AHM_Settings_Model_Interface {

    /**
     * Read Setting
     *
     * @access public
     * @param string $param
     * @return mixed
     */
    public function read($param);

    /**
     * Insert or Update Setting
     *
     * @access public
     * @param string $param
     * @param mixed $value
     * @return boolean
     */
    public function update($param, $value);

    /**
     * Delete Setting
     *
     * @access public
     * @param string @param
     * @return boolean
     */
    public function delete($param);
}