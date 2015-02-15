<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Error Storage File Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/11/2012
 */
class AHM_Error_Model_Storage_File extends AHM_Error_Model_Storage_Abstract {
    
    /**
     * Indicator that the error log file has been scanned completely
     *
     * @var boolean
     *
     * @access private
     */
    private $_complete = false;

    /**
     * File pointer to seek to
     *
     * @var int
     *
     * @access private
     */
    private $_ftell = 0;

    /**
     * @inheritdoc
     */
    public function __destruct() {
        if (!defined('AHM_ERROR_LOG_FAILURE')){
            file_put_contents($this->getCacheFilename(), serialize($this));
        }
    }


    /**
     * Get real path to cache file
     *
     * @access protected
     * @return string
     */
    protected function getCacheFilename() {
        return AHM_ERROR_CACHEDIR . DIRECTORY_SEPARATOR . $this->getDate();
    }

    /**
     * Return the list of valiables to serialize
     *
     * @access public
     * @return array
     */
    public function __sleep() {
        return array('_storage', '_complete', '_ftell', '_date');
    }
    
    /**
     * Make sure that all necessary properties are correct
     * 
     * @return void
     * 
     * @access public
     */
    public function __wakeup() {
        if ($this->getDate() == date(AHM_ERROR_DATEFORMAT)){
            $this->setComplete(false);
        }
    }

    /**
     * Set Complete flag
     *
     * @param boolean $complete
     *
     * @return void
     *
     * @access public
     */
    public function setComplete($complete){
        $this->_complete = $complete;
    }

    /**
     * Get Complete flag
     *
     * @return boolean
     *
     * @access public
     */
    public function getComplete(){
        return $this->_complete;
    }

    /**
     * Set File pointer
     *
     * @param int $ftell
     *
     * @return void
     *
     * @access public
     */
    public function setFtell($ftell){
        $this->_ftell = $ftell;
    }

    /**
     * Get File pointer
     *
     * @return int
     *
     * @access public
     */
    public function getFtell(){
        return $this->_ftell;
    }

}