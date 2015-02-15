<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Apply Queue Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/11/2013
 */
class AHM_Error_Model_Queue_Apply extends AHM_Error_Model_Queue_Abstract {

    /**
     * This is important for backup to handle the case when first file backuped
     * at 11.59:59pm and second after midnight
     *
     * @var string
     *
     * @access private
     */
    private $_date;

    /**
     * Constructor
     *
     * @access public
     * @param AHM_Core_Controller $ctrl
     */
    public function __construct() {
        $this->_file = AHM_ERROR_CACHEDIR . DIRECTORY_SEPARATOR . '_apply';
        $this->_date = date('Y-m-d');

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
        $patches = AHM_Core_Request::post('patch', array());
        if (count($patches)) {
            foreach (Router::call('Error.errors') as $storage) {
                foreach ($storage as $info) {
                    if (isset($info['patch'])
                            && in_array($info['patch'], $patches)) {
                        //in case the patch is already in queue, overwrite it
                        //with new array to make sure that checksum is the
                        //latest. This is Important to do!
                        //And remember - one patch is one subject (file)
                        $this->_queue[$info['patch']] = array(
                            'id' => $info['patch'],
                            'relpath' => $info['relpath'],
                            'syspath' => $info['syspath'],
                            'checksum' => $info['checksum']
                        );
                    }
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
    public function run($limit = 1) {
        $account = Router::call('Settings.account');
        //Success response anyway. The getResults function secures the stop
        //queue flag. Snapshot Bug Report #78790
        $response = array('status' => 'success');

        for ($i = 1; ($i <= $limit) && $this->valid(); $i++) {
            $patch = $this->next();
            if (is_writable($patch['syspath'])) { //1. Is file writable?
                if ($this->backup($patch)) { //2. Backuped successfully
                    $data = Router::call(
                                    'Service.apply', $account, $patch['id']
                    );
                    if ($data->status === 'success') { //3. Server responded?
                        if (file_put_contents(
                                        $patch['syspath'],
                                        base64_decode($data->content))
                        ) {
                            $response = array('status' => 'success');
                            //update current balance
                            Router::call('Settings.balance', $data->balance);
                        } else {
                            $response = array(
                                'status' => 'failed',
                                'reason' => 'F04: File Patching Failure'
                            );
                        }
                    } else {
                        $response = array(
                            'status' => 'failed',
                            'code' => $data->code,
                            'reason' => 'F03: Download Failure'
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'failed',
                        'reason' => 'F02: Backup Failure'
                    );
                }
            } else {
                $response = array(
                    'status' => 'failed',
                    'reason' => 'F01: File is not writable'
                );
            }
        }

        return $this->getResult($response);
    }

    /**
     * Backup the file for patching to the proper directory
     *
     * @param array $patch
     *
     * @return boolean
     *
     * @access protected
     */
    protected function backup($patch) {
        $result = true;
        //create backup folder path
        if (!file_exists(AHM_BACKUP_DIR)) {
            $result = mkdir(AHM_BACKUP_DIR);
        }

        if ($result) {
            $basedir = AHM_BACKUP_DIR;
            //exclude first / from rel path!
            $relpath = $this->_date . dirname($patch['relpath']);
            foreach (explode('/', $relpath) as $chunk) {
                $basedir .= DIRECTORY_SEPARATOR . $chunk;
                if (!file_exists($basedir) && (mkdir($basedir) === false)) {
                    $result = false;
                    break;
                }
            }
            $dest = $basedir . DIRECTORY_SEPARATOR . basename($patch['relpath']);
            //do not overwrite the file that is already stored for today
            //this is important to keep the very first version of the file for
            //current date
            if ($result && !file_exists($dest)) {
                $result = copy($patch['syspath'], $dest);
            }
        }

        return $result;
    }

}