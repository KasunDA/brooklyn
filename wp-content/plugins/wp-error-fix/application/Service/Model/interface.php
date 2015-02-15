<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Interface for Web Service
 *
 * @package WordPress\WP Error Fix\Service
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/13/2012
 */
interface AHM_Service_Model_Interface{

    /**
     * Register the System Instance
     *
     * This request should be sent first (before any other activity)
     *
     * @param string $host
     * @param string $environment
     *
     * @return boolean
     *
     * @access public
     */
    public function register($host, $environment);

    /**
     * Report error
     *
     * @param string $instance
     * @param string $module
     * @param string $file
     * @param string $version
     * @param string $checksm
     * @param int    $level
     * @param string $message
     * @param int    $line
     *
     * @return int Report Status
     *
     * @access public
     */
    public function report($instance, $module, $file, $version, $checksum,
                                                            $level, $message, $line);

    /**
     * Check for available solutions
     *
     * @param string $instance
     * @param int    $reportID
     *
     * @return object Server Response
     *
     * @access public
     */
    public function check($instance, $reportID);

    /**
     * Apply Patch to the file
     *
     * @param string $instance System Instance number
     * @param int    $patchID  Patch ID
     *
     * @return object Server Response
     *
     * @access public
     */
    public function apply($instance, $patchID);
    
    /**
     * Get Instance current balance
     * 
     * @param string $instance System Instance number
     * 
     * @return object Server Response
     * 
     * @access public
     */
    public function balance($instance);

}