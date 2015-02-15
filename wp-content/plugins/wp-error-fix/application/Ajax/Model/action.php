<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Ajax action model
 *
 * @package WordPress\WP Error Fix\Ajax
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/14/2012
 */
class AHM_Ajax_Model_Action {
    /**
     * Ajax Response status SUCCESS
     */

    const STATUS_SUCCESS = 'success';

    /**
     * Ajax Response status FAILED
     */
    const STATUS_FAILED = 'failed';

    /**
     * Handle Ajax Request
     *
     * @return string JSON encoded response
     *
     * @access public
     */
    public function handle() {
        switch (AHM_Core_Request::request('sub_action')) {
            //Trigger different view. Initiated after user changed "Screen" drop-down
            case 'trigger_view':
                $response = Router::call(
                        'View.retrieveView',
                        AHM_Core_Request::request('view')
                );
                break;
            //clear filters for Error List
            case 'clear_filters':
                $dump = Router::call('Settings.ui');
                $dump['type'] = $dump['module'] = '';
                if (Router::call('Settings.ui', $dump)) {
                    $result = array('status' => self::STATUS_SUCCESS);
                } else {
                    $result = array('status' => self::STATUS_FAILED);
                }
                $response = json_encode($result);
                break;
            //Save UI Option. Initiated for control elements of GUI
            case 'save_option':
                $dump = Router::call('Settings.ui');
                $key = AHM_Core_Request::request('key');
                $dump[$key] = AHM_Core_Request::request('value');
                if (Router::call('Settings.ui', $dump)) {
                    $result = array('status' => self::STATUS_SUCCESS);
                } else {
                    $result = array('status' => self::STATUS_FAILED);
                }
                $response = json_encode($result);
                break;
            //get UI option
            case 'get_option':
                $dump = Router::call('Settings.ui');
                if (isset($dump[$_REQUEST['key']])) {
                    $result = array(
                        'status' => self::STATUS_SUCCESS,
                        'data' => $dump[$_REQUEST['key']]
                    );
                } else {
                    $result = array(
                        'status' => self::STATUS_SUCCESS,
                        'data' => ''
                    );
                }
                $response = json_encode($result);
                break;
            //Save preferences
            case 'preference':
                Router::call(
                        'Settings.preference', 
                        AHM_Core_Request::request('preference', array())
                );
                $response = json_encode(array('status' => self::STATUS_SUCCESS));
                break;
            //Register new system. Send REST Request
            case 'register':
                $result = Router::call(
                              'Service.register',
                              Router::call('Factory.baseURL'),
                              Router::call('Factory.getEnvironment')
                );
                $ui = Router::call('Settings.ui');
                if ($result->status == 'success') {
                    Router::call('Settings.account', $result->instance);
                    $result = array('status' => self::STATUS_SUCCESS);
                    //update the setting that user is registered
                    $ui['registered'] = true;
                    Router::call('Settings.ui', $ui);
                } else {
                    $result = array('status' => self::STATUS_FAILED);
                    $ui['registered'] = false;
                    Router::call('Settings.ui', $ui);
                }
                $response = json_encode($result);
                break;
            //Send reports to the server
            case 'report':
                $queue = Router::call('Error.reportQueue');
                $response = json_encode($queue->run());
                break;
            //Send Emergency Request
            case 'balance':
                $result = Router::call(
                              'Service.balance',
                              Router::call('Settings.account')
                );
                if ($result->status == 'success') {
                    Router::call('Settings.balance', $result->balance);
                    $result = array(
                        'status' => self::STATUS_SUCCESS,
                        'balance' => sprintf('%01.2f', $result->balance)
                    );
                } else {
                    $result = array('status' => self::STATUS_FAILED);
                }
                $response = json_encode($result);
                break;
            //Analyze error logs before rendering
            case 'analyze':
                $queue = Router::call('Error.analyze');
                $result = $queue->run();
                $response = json_encode($result);
                break;
            //check for available solutions
            case 'check':
                $queue = Router::call('Error.checkQueue');
                $response = json_encode($queue->run());
                break;
            //apply patch
            case 'apply':
                $patcher = Router::call('Error.applyQueue');
                $response = json_encode($patcher->run());
                break;
            //Clear error logs and cache
            case 'clean':
                $res = Router::call('Error.clean');
                $response = json_encode(array(
                    'status' => ($res ? self::STATUS_SUCCESS : self::STATUS_FAILED)
                ));
                break;
            //check for number of available solutions
            case 'available_fixnum':
                $number = 0;
                foreach (Router::call('Error.errors') as $storage) {
                    foreach ($storage as $report) {
                        if ($report['status'] == AHM_ERROR_STATUS_RESOLVED) {
                            $number++;
                        }
                    }
                }
                $response = json_encode(array('number' => $number));
                break;

            //Oops! Sounds like somethings weird :)
            default:
                $response = json_encode(array('status' => self::STATUS_FAILED));
                break;
        }

        return $response;
    }

}