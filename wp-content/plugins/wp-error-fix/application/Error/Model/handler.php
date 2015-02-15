<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Error Handler Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/11/2012
 */
class AHM_Error_Model_Handler {

    /**
     * Store the list of errors here & write them to file during destruct
     *
     * @var array
     *
     * @access private
     */
    private $_cache = array();

    /**
     * MD5 File Content
     *
     * @var array
     *
     * @access private
     */
    private $_fileHash = array();

    /**
     * Write the catched list of errors to the log file
     *
     * @return void
     *
     * @access public
     */
    public function __destruct() {
        $logname = $this->getLogPath();
        if (!file_exists($logname) || filesize($logname) < AHM_ERROR_LOGSIZE) {
            if (count($this->_cache) && !defined('AHM_ERROR_LOG_FAILURE')) {
                file_put_contents(
                        $logname, implode('', $this->_cache), FILE_APPEND
                );
                //clean-up the cache to prevent from double write, just in case...
                $this->_cache = array();
            }
        }
    }

    /**
     * Handler Error and Log it to file
     *
     * @access public
     * @param string $no
     * @param string $msg
     * @param string $file
     * @param string $line
     */
    public function handle($no, $msg, $file, $line) {
        if (file_exists($file)){
            $time = date('Y-m-d H:i:s');
            $msg = str_replace(array("\r", "\n"), array('', ''), $msg);
            $checksum = $this->getChecksum($file);
            $error = "{$time}||{$no}||{$msg}||{$file}||{$line}||{$checksum}\n";
            $this->_cache[] = $error;
        }
    }

    /**
     * Get file checksum
     *
     * @access protected
     * @param string $file
     * @return string
     */
    protected function getChecksum($file) {
        if (!isset($this->_fileHash[$file])) {
            $this->_fileHash[$file] = md5(file_get_contents($file));
        }

        return $this->_fileHash[$file];
    }

    /**
     * Get Log filename
     *
     * @access protected
     * @return string
     */
    protected function getLogPath() {
        return AHM_ERROR_LOGDIR . '/' . date(AHM_ERROR_DATEFORMAT);
    }

}