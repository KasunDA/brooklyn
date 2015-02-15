<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Check Queue Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 05/16/2013
 */
class AHM_Error_Model_Queue_Check extends AHM_Error_Model_Queue_Abstract {

    /**
     * Number of found solution during current batch
     * 
     * @var int
     * 
     * @access private 
     */
    private $_found = 0;
    
    /**
     * Constructor
     *
     * @access public
     * @param AHM_Core_Controller $ctrl
     */
    public function __construct() {
        $this->_file = AHM_ERROR_CACHEDIR . DIRECTORY_SEPARATOR . '_check';
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
            foreach ($storage as $hash => $info) {
                if (!isset($this->_queue[$hash])
                        && ($info['status'] == AHM_ERROR_STATUS_REPORTED)) {
                    $this->_queue[$hash] = $info;
                }
            }
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
            $result = Router::call(
                            'Service.check', $account, $error['report']
            );

            if ($result->status == 'success') {
                $this->updateReport($hash, $result);
            } //ignore failed check. Run it again next time
        }
        
        //if there is any found solution, notify the user
        if ($this->_found){
            Router::call('Email.notifySolution');
        }

        return $this->getResult();
    }
    
    /**
     * Update the report with server response
     * 
     * @param string   $hash
     * @param stdClass $result
     * 
     * @return void
     * 
     * @access protected
     */
    protected function updateReport($hash, $result) {
        if (isset($result->patch)) {
            $this->update($hash, array(
                'status' => AHM_ERROR_STATUS_RESOLVED,
                'patch' => $result->patch,
                'price' => $result->price
            ));
            $this->_found++;
        } elseif (isset($result->reject)) {
            $this->update($hash, array(
                'status' => AHM_ERROR_STATUS_REJECTED,
                'reason' => $result->reason
            ));
        }
    }

}