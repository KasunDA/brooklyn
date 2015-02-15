<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * List of storages
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 03/03/2013
 */
class AHM_Error_Model_List {

    /**
     * List of storages
     *
     * @var array
     *
     * @access private
     */
    private $_list = array();

    /**
     * Single instance of itself
     *
     * @var AHM_Error_Model_List
     *
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * Constructor
     *
     * @return void
     *
     * @access public
     */
    public function __construct() {
        $start_date = date(
                AHM_ERROR_DATEFORMAT,
                strtotime('today -' . AHM_ERROR_DAYCOUNT . ' days')
        );
        foreach (scandir(AHM_ERROR_CACHEDIR) as $file) {
            $filename = realpath(AHM_ERROR_CACHEDIR . '/' . $file);
            //valid file && within date range
            if (preg_match('/^[\d\-]+$/', $file) && ($file >= $start_date)) { 
                $storage = AHM_Error_Model_Cache::getCache($filename);
                if ($storage instanceof AHM_Error_Model_Storage_Abstract) {
                    //filter storage from resolved and inactual errors
                    while($storage->valid()){
                        if ($this->validChecksum($storage->current()) === false) {
                            $storage->remove($storage->key());
                        }else{
                            $storage->next();
                        }
                    }
                    $this->_list[$storage->getDate()] = $storage;
                }
            } elseif (is_file($filename)) { //remove storage. It is retired
                unlink($filename);
            }
        }
    }

    /**
     * Validate the report's and actual file checksum
     *
     * @param array $report
     *
     * @return boolean
     *
     * @access protected
     */
    protected function validChecksum($report) {
        static $checksum = array();

        $response = false;
        //make sure that file still exists
        if (file_exists($report['syspath'])) {
            if (!isset($checksum[$report['syspath']])) {
                //get current checksum
                $checksum[$report['syspath']] = md5(
                        file_get_contents($report['syspath'])
                );
            }
            //is it the same as it was reported?
            if ($checksum[$report['syspath']] == $report['checksum']) {
                $response = true;
            }
        }

        return $response;
    }

    /**
     * Get list
     *
     * @return array
     *
     * @access public
     */
    public function getList() {
        return $this->_list;
    }

    /**
     * Get total number of errors
     *
     * @return int
     *
     * @access public
     */
    public function count() {
        $hashTable = array();
        foreach ($this->getList() as $storage) {
            foreach ($storage as $hash => $data) {
                $hashTable[] = $hash;
            }
        }

        return count(array_unique($hashTable));
    }

    /**
     * Get single instance of itself
     *
     * @return AHM_Error_Model_List
     *
     * @access public
     * @static
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}