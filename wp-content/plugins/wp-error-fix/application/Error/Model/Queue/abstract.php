<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Abstract Queue Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 05/16/2013
 */
abstract class AHM_Error_Model_Queue_Abstract {

    /**
     * Check queue
     *
     * @var array
     *
     * @access protected
     */
    protected $_queue = array();

    /**
     * Path to Queue Cache file
     *
     * @access protected
     * @var string
     */
    protected $_file;

    /**
     * Store files checksum cache to make sure that the current file
     * is the same as it was when error was triggered
     *
     * @var array
     *
     * @access protected
     */
    protected $_checksumCache = array();

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct() {
        if (file_exists($this->_file)) {
            $this->_queue = AHM_Error_Model_Cache::getCache($this->_file);
        } else {
            $this->createQueue();
        }
    }

    /**
     * Desctructor
     *
     * @access public
     */
    public function __destruct() {
        if ($this->count() && !defined('AHM_ERROR_CACHE_FAILURE')) {
            //clear checksum cache
            $this->_checksumCache = array();
            //save the queue for next iteration
            file_put_contents($this->_file, serialize($this->_queue));
        } elseif (file_exists($this->_file)) { //if errors  were less than limit
            unlink($this->_file);
        }
    }

    /**
     * Get Complete Error List and create a well-formated queue
     *
     * @access protected
     */
    abstract protected function createQueue();

    /**
     * Run Queue
     *
     * @var int $limit
     *
     * @return array
     *
     * @access public
     */
    abstract public function run($limit = AHM_ERROR_QUEUELIMIT);

    /**
     * Check how many records are in queue
     *
     * @access public
     * @return int
     */
    public function count() {
        return count($this->_queue);
    }

    /**
     * Get Next error in queue
     *
     * @access public
     * @return array
     */
    public function next() {
        return array_shift($this->_queue);
    }

    /**
     * Get current error hash key
     *
     * @access public
     * @return string
     */
    public function key() {
        return key($this->_queue);
    }

    /**
     * Check if the Queue does not reach the end
     *
     * @access public
     * @return boolean
     */
    public function valid() {
        return (is_array(current($this->_queue)) ? TRUE : FALSE);
    }

    /**
     * Clear queue
     *
     * @access public
     */
    public function clear() {
        $this->_queue = array();
    }

    /**
     * Update Error Status in Storages
     *
     * @access protected
     * @staticvar array $errorList
     * @param string $hash
     * @param string $data
     */
    protected function update($hash, $data) {
        static $errorList;

        if (is_null($errorList)) {
            $errorList = Router::call('Error.errors');
        }
        foreach ($errorList as $storage) {
            $storage->update($hash, $data);
        }
    }

    /**
     * Get Queueu execution result
     *
     * @param array $additional
     *
     * @return array
     *
     * @access protected
     */
    protected function getResult($additional = array()) {
        if ($this->valid()) {
            $result = array(
                'stop' => FALSE,
                'queue' => $this->count()
            );
        } else {
            $result = array(
                'stop' => TRUE,
                'queue' => 0
            );
        }

        return array_merge($result, $additional);
    }

}