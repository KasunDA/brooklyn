<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Analyze Log Queue Model
 *
 * This is very important part of error grouping feature. In case of error logs
 * which have megs of information, this will divide the analyzing process on
 * phases. The set_time_limit is pretty ugly solution and that is why it turned
 * to more complex way of analyzing.
 * The idea is simple - analyze 1000 (configurable value) lines per request till
 * all logs will have caches object inside the Error/_files folder
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/10/2012
 */
class AHM_Error_Model_Queue_Analyze extends AHM_Error_Model_Queue_Abstract {

    /**
     * Constructor
     *
     * @access public
     * @param AHM_Core_Controller $ctrl
     */
    public function __construct() {
        $this->_file = AHM_ERROR_CACHEDIR . DIRECTORY_SEPARATOR . '_analyze';
        parent::__construct();
    }

    /**
     * Get Complete Error List and create a well-formated queue
     *
     * @access protected
     */
    protected function createQueue() {
        //prepare required settings
        $this->clear();
        $start_date = date(
                AHM_ERROR_DATEFORMAT,
                strtotime('today -' . AHM_ERROR_DAYCOUNT . ' days')
        );

        foreach (scandir(AHM_ERROR_LOGDIR) as $file) {
            //valid file && within date range
            if (preg_match('/^[\d\-]+$/', $file) && ($file >= $start_date)) {
                $storage = $this->getStorage($file);
                if ($storage->getComplete() === false
                        || ($file == date(AHM_ERROR_DATEFORMAT))
                ) {
                    $this->_queue[] = $storage;
                }
            }
        }
    }

    /**
     * Get Storage
     *
     * @return AHM_Error_Model_Storage
     *
     * @access public
     */
    protected function getStorage($date = null) {
        $className = 'AHM_Error_Model_Storage_' . ucfirst(AHM_ERROR_STORAGE);
        if ($date) {
            $filename = AHM_ERROR_CACHEDIR . '/' . $date;
            $storage = AHM_Error_Model_Cache::getCache($filename);
            if (!is_object($storage) || (get_class($storage) != $className)) {
                $storage = new $className;
            }
            $storage->setDate($date);
        } else {
            $storage = new $className;
        }

        return $storage;
    }

    /**
     * Run Queue
     *
     * @access public
     * @return array
     */
    public function run($limit = AHM_ERROR_QUEUELIMIT) {
        $parser = AHM_Error_Model_Parser::getInstance();
        //scan one storage per request
        if ($this->valid()) {
            $parser->run(current($this->_queue));
            if (current($this->_queue)->getComplete()) {
                array_shift($this->_queue);
            }
        }

        return $this->getResult();
    }

    /**
     * Check if the Queue does not reach the end
     *
     * @access public
     * @return boolean
     */
    public function valid() {
        return (current($this->_queue) ? TRUE : FALSE);
    }

}