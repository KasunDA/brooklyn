<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Error Parser Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/11/2012
 */
class AHM_Error_Model_Parser {

    /**
     * Storage for list of errors
     *
     * @access private
     * @var array
     */
    private $_storage = NULL;

    /**
     * Single instance of itself
     *
     * Is very importand to have only single instance to
     * avoid mismatch in error list
     *
     * @access private
     * @var AHM_Error_Model_Parser
     */
    private static $_instance = NULL;

    /**
     * Handle the request
     *
     * @access public
     * @return array
     */
    public function run(AHM_Error_Model_Storage_Abstract $storage) {
        $this->setStorage($storage);

        return $this->scanFile();
    }

    /**
     * Clean the log directory
     *
     * @return boolean
     */
    public function clean() {
        //clean the log dir
        foreach (scandir(AHM_ERROR_LOGDIR) as $file) {
            $filename = realpath(AHM_ERROR_LOGDIR . '/' . $file);
            if (is_file($filename)
                    && preg_match('/^[\d\-]+$/', $file)
                    && ($file != '.htaccess')
            ) { //valid file && within date range
                unlink($filename);
            }
        }
        //clean the cache dir
        foreach (scandir(AHM_ERROR_CACHEDIR) as $file) {
            $filename = realpath(AHM_ERROR_CACHEDIR . '/' . $file);
            if (is_file($filename)) {
                unlink($filename);
            }
        }

        return true;
    }

    /**
     * Scan Log file and prepare Storage Object
     *
     * @access protected
     */
    protected function scanFile() {
        $storage = $this->getStorage();
        $file = AHM_ERROR_LOGDIR . '/' . $storage->getDate();
        if (is_readable($file) && ($fhr = fopen($file, "r"))) {
            $lines = 0;
            fseek($fhr, $storage->getFtell());
            while (($row = fgets($fhr)) && ($lines < AHM_ERROR_SCANLIMIT) ) {
                $this->parseRow($row);
                $lines++;
            }
            $storage->setFtell(ftell($fhr));
            $storage->setComplete(feof($fhr));
        }
    }

    /**
     * Parser Log Row and insert it to Storage
     *
     * @access protected
     * @param string $row
     */
    protected function parseRow(&$row) {
        $chk = explode('||', trim($row));
        if (count($chk) == 6) { //do not parse corrupted strings
            $this->getStorage()->add(
                    $chk[0], $chk[1], $chk[2], $chk[3], $chk[4], $chk[5]
            );
        }
    }

    /**
     * Set storage
     *
     * @param AHM_Error_Model_Storage_Abstract $storage
     *
     * @return void
     *
     * @access public
     */
    public function setStorage(AHM_Error_Model_Storage_Abstract $storage) {
        $this->_storage = $storage;
    }

    /**
     * Get storage
     *
     * @return AHM_Error_Model_Storage_Abstract
     *
     * @access public
     */
    public function getStorage() {
        return $this->_storage;
    }

    /**
     * Get Single instance of itself
     *
     * @access public
     * @return AHM_Error_Model_Parser
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}