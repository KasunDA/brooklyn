<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Error Controller
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/15/2012
 */
class AHM_Error_Controller {

    /**
     * Single Instance of itself
     *
     * @var AHM_Error_Controller
     *
     * @access private
     */
    private static $_instance = NULL;
    
    /**
     * Error Log handler
     * 
     * @var AHM_Error_Model_Handler
     * 
     * @access private 
     */
    private $_handler = null;

    /**
     * Initialize Error Handling
     *
     * @access public
     *
     * @return void
     */
    public function init() {
        set_error_handler(array($this, 'handler'));
        set_exception_handler(array($this, 'exception'));
        register_shutdown_function(array($this, 'shutdownHandler'));
    }

    /**
     * Initialize the file structure for bug tracker
     *
     * @return void
     *
     * @access public
     */
    public function filebase() {
        if (!defined('AHM_ERROR_LOGDIR')) {
            //define module constants
            $sep = DIRECTORY_SEPARATOR;
            define(
                    'AHM_ERROR_LOGDIR',
                    Router::call('Factory.contentDir') . $sep . 'wp_errorfix'
            );
            //legacy
            define(
                    'AHM_ERROR_LOGDIR_LEGACY',
                    Router::call('Factory.contentDir') . $sep . 'ahmlog'
            );
            define('AHM_ERROR_CACHEDIR', AHM_ERROR_LOGDIR . $sep . '_cache');
            define('AHM_BACKUP_DIR', AHM_ERROR_LOGDIR . $sep . '_backup');
            //create log storage folder with necessary htaccess file
            if (file_exists(AHM_ERROR_LOGDIR_LEGACY)){
                if (rename(AHM_ERROR_LOGDIR_LEGACY, AHM_ERROR_LOGDIR) === FALSE){
                    define('AHM_ERROR_LOG_FAILURE', 1);
                }
            }elseif (!file_exists(AHM_ERROR_LOGDIR)) {
                if (mkdir(AHM_ERROR_LOGDIR)) {
                    //create htaccess file
                    file_put_contents(
                            AHM_ERROR_LOGDIR . $sep . '.htaccess',
                            'IndexIgnore *'
                    );
                } else {
                    define('AHM_ERROR_LOG_FAILURE', 1);
                }
            }
            //create cache directory
            if (!file_exists(AHM_ERROR_CACHEDIR)) {
                //make cache directory
                if (!mkdir(AHM_ERROR_CACHEDIR)) {
                    define('AHM_ERROR_CACHE_FAILURE', 1);
                }
            }
            //create backup directory
            if (!file_exists(AHM_BACKUP_DIR)) {
                //make cache directory
                if (!mkdir(AHM_BACKUP_DIR)) {
                    define('AHM_ERROR_BACKUP_FAILURE', 1);
                }
            }
        }
    }

    /**
     * Get Single Instance of itself
     *
     * @access public
     * @return AHM_Error_Controller
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Get Error List
     *
     * @access public
     * @return array
     */
    public function errors() {
        return AHM_Error_Model_List::getInstance()->getList();
    }

    /**
     * Return total number of errors
     *
     * This function is used for Admin Menu notification
     *
     * @return int
     *
     * @access public
     */
    public function errorCount(){
        return AHM_Error_Model_List::getInstance()->count();
    }

    /**
     * Analyze the list of logs. Prepare cache
     *
     * @return string JSON encoded result
     *
     * @access public
     */
    public function analyze(){
        return new AHM_Error_Model_Queue_Analyze();
    }

    /**
     * Clean the log directory
     *
     * @return boolean
     */
    public function clean(){
        return AHM_Error_Model_Parser::getInstance()->clean();
    }

    /**
     * Get Statistic information
     *
     * @param string $type
     *
     * @return array
     *
     * @access puclic
     */
    public function statistics($type = 'general'){
        $className = 'AHM_Error_Model_Statistic_' . ucfirst($type);

        return call_user_func(array($className, 'getInstance'))->run();
    }

    /**
     * Handler Error and Log it to file
     *
     * @param string $no
     * @param string $msg
     * @param string $file
     * @param string $line
     *
     * @access public
     */
    public function handler($no, $msg, $file, $line) {
        if (error_reporting() & $no){
            if (is_null($this->_handler)) {
                $this->_handler = new AHM_Error_Model_Handler();
            }
            $this->_handler->handle($no, $msg, $file, $line);
        }
    }

    /**
     * Get Report queue
     *
     * @return \AHM_Error_Model_Queue_Report
     *
     * @access public
     */
    public function reportQueue(){
        return new AHM_Error_Model_Queue_Report();
    }

    /**
     * Get Check queue
     *
     * @return \AHM_Error_Model_Queue_Check
     *
     * @access public
     */
    public function checkQueue(){
        return new AHM_Error_Model_Queue_Check();
    }

    /**
     * Actuall Patcher
     *
     * @return \AHM_Error_Model_Patcher
     *
     * @access public
     */
    public function applyQueue(){
        return new AHM_Error_Model_Queue_Apply();
    }

    /**
     * Exception handler
     *
     * @param Exception $e
     *
     * @access public
     */
    public function exception($e) {
        $msg = 'Uncatched exception ' . get_class($e) . ': ' . $e->getMessage();
        $this->handler(E_ERROR, $msg, $e->getFile(), $e->getLine());
    }

    /**
     * Handle Shut Down Process
     *
     * @access public
     */
    public function shutdownHandler() {
        if ($e = error_get_last()) {
            if (in_array($e['type'], array(E_ERROR, E_USER_ERROR))) {
                $this->handler(
                        $e['type'], $e['message'], $e['file'], $e['line']
                );
                //force to destruct the _handler to write down the error
                //potensial bug in PHP. Does not call destructor when Fatal Error
                //occurred
                $this->_handler->__destruct();
            }
        }
    }

}