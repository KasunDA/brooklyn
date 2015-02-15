<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Report Queue Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/10/2012
 */
class AHM_Error_Model_Queue_Report extends AHM_Error_Model_Queue_Abstract {

    /**
     * Constructor
     *
     * @access public
     * @param AHM_Core_Controller $ctrl
     */
    public function __construct() {
        $this->_file = AHM_ERROR_CACHEDIR . DIRECTORY_SEPARATOR . '_report';
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
        foreach (Router::call('Error.errors') as $storage) {
            //list of allowed statuses to include in queue
            $allowed = array(
                AHM_ERROR_STATUS_NEW, //obviously new should be here
                AHM_ERROR_STATUS_FAILED //in case it failed last time
            );
            foreach ($storage as $hash => $info) {
                if (!isset($this->_queue[$hash])
                        && in_array($info['status'], $allowed)) {
                    $this->_queue[$hash] = $info;
                }
            }
        }
        
        //send email address if there is anything in queue
        if ($this->count()){
            Router::call('Email.notifyError');
        }
    }

    /**
     * Run Queue
     *
     * @var int $limit
     *
     * @return array
     *
     * @access public
     */
    public function run($limit = AHM_ERROR_QUEUELIMIT) {
        $account = Router::call('Settings.account');
        for ($i = 1; ($i <= $limit) && $this->valid(); $i++) {
            $hash = $this->key();
            $error = $this->next();
            switch ($error['status']) {
                case AHM_ERROR_STATUS_NEW:
                case AHM_ERROR_STATUS_FAILED:
                    $result = Router::call(
                                    'Service.report',
                                    $account,
                                    $error['module'],
                                    $error['modpath'],
                                    $error['version'],
                                    $error['checksum'],
                                    $error['level'],
                                    $error['message'],
                                    $error['line']
                    );
                    if ($result->status == 'success') {
                        $this->update($hash, array(
                            'status' => AHM_ERROR_STATUS_REPORTED,
                            'report' => $result->reportID
                        ));
                    } else {
                        $this->update($hash, array(
                            'status' => AHM_ERROR_STATUS_FAILED
                        ));
                    }
                    break;

                default:
                    break;
            }
        }

        return $this->getResult();
    }

}