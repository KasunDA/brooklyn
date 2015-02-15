<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Settings Controller
 *
 * @package WordPress\WP Error Fix\Settings
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/11/2012
 */
class AHM_Settings_Controller {

    /**
     * Settings Storage type
     *
     * @access protected
     * @var string
     */
    protected $_storage;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct() {
        $storage  = 'AHM_Settings_Model_' . ucfirst(AHM_SETTINGS_STORAGE);
        $this->_storage = call_user_func(array($storage, 'getInstance'));
    }

    /**
     * Get UI settings
     *
     * @access public
     * @param array $data
     * @return mixed
     */
    public function ui($data = NULL){
        if (is_null($data)){
            $result = $this->read(AHM_SETTINGS_UIOPT);
        }else{
            $result = $this->update(AHM_SETTINGS_UIOPT, $data);
        }
        return $result;
    }

    /**
     * Get/Set account ID
     *
     * @param string $data
     *
     * @return boolean
     */
    public function account($data = NULL){
        if (is_null($data)){
            $result = $this->read(AHM_SETTINGS_ACCOUNTOPT);
        }else{
            $result = $this->update(AHM_SETTINGS_ACCOUNTOPT, $data);
        }
        
        return $result;
    }
    
    /**
     * Get/Set account balance
     *
     * @param float $data
     *
     * @return boolean
     */
    public function balance($amount = NULL){
        if (is_null($amount)){
            $result = floatval($this->read(AHM_SETTINGS_BALANCEOPT));
        }else{
            $result = $this->update(AHM_SETTINGS_BALANCEOPT, $amount);
        }
        
        return $result;
    }
    
    /**
     * Get/Set preferences
     *
     * @param array $data
     *
     * @return boolean
     */
    public function preference($data = NULL){
        if (is_null($data)){
            $result = $this->read(AHM_SETTINGS_PREFERENCEOPT);
        }else{
            $result = $this->update(AHM_SETTINGS_PREFERENCEOPT, $data);
        }
        
        return $result;
    }

    /**
     * Get Setting based on requested $param
     *
     * @access public
     * @param string $param
     * @return mixed
     */
    public function read($param){
        return $this->_storage->read($param);
    }

    /**
     * Insert or Update Setting based on requested $param
     *
     * @access public
     * @param string $param
     * @return mixed
     */
    public function update($param, $value){
        return $this->_storage->update($param, $value);
    }

    /**
     * Remove GUI settings but keep the account ID
     *
     * @return boolean
     */
    public function removeUI(){
        return $this->_storage->delete(AHM_SETTINGS_UIOPT);
    }

}