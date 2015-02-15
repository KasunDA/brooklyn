<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Interface for Factory
 *
 * @package WordPress\WP Error Fix\Factory
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/19/2012
 */
interface AHM_Factory_Model_Interface{

    /**
     * Get Module Information based on file path
     *
     * This Function should return an associated array with next parameters:
     * array(
     *    'module' => (string) [Module Name],
     *    'version' => (string) [Module Version],
     *    'meta' => (mixed) [Any Related information about the Module],
     *    'sysPath' => (string) [Path to the file from the Application root]
     * )
     *
     * @access public
     * @param string $filepath
     */
    public function getModuleInfo($filepath);

    /**
     * Localize Label
     *
     * @access public
     * @param string $label
     * @param string $domain
     * @return string
     */
    public function lang($label, $domain = NULL);

    /**
     * Get System Absolute Path
     *
     * @access public
     * @return string
     */
    public function absPath();

    /**
     * Get base site URL
     *
     * @access public
     * @return string
     */
    public function baseURL();

    /**
     * Get Environment Name
     *
     * @access public
     * @return string
     */
    public function getEnvironment();

    /**
     * Send Remove request
     *
     * @param string $url
     * @param array  $params
     *
     * @return mixed
     *
     * @access public
     */
    public function remoteRequest($url, $params = array());

}