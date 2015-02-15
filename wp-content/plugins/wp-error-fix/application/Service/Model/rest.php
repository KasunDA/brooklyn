<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Rest Client for Web Service
 *
 * @package WordPress\WP Error Fix\Service
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 09/13/2012
 */
class AHM_Service_Model_Rest implements AHM_Service_Model_Interface {

    /**
     * URI to REST Service
     *
     * @access protected
     * @var string
     */
    protected $_uri;

    /**
     * Session ID
     *
     * @access protected
     * @var string
     */
    protected $_session = NULL;

    /**
     * Constructor
     *
     * @access public
     * @param AHM_Service_Controller $controller
     */
    public function __construct() {
        if (getenv('APPL_ENV') == 'development') {
            $this->_uri = AHM_SERVICE_TESTURL;
        } else {
            $this->_uri = AHM_SERVICE_URL;
        }
    }

    /**
     * Send actual REST Request to the Server
     *
     * @access protected
     * @param string $params
     * @return \stdClass
     */
    protected function sendRequest($params) {
        $result = Router::call('Factory.remoteRequest', $this->_uri, $params);
        $response = new stdClass();
        $response->status = 'failed';
        //parse response and make sure that this is right one
        if ($result) {
            $decoded = json_decode($result);
            //make sure that the right result returned. Otherwise failure
            if ($decoded instanceof stdClass){
                $response = $decoded;
            }
        }

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function register($host, $environment) {
        return $this->sendRequest(array(
                    'method' => 'register',
                    'host' => $host,
                    'env' => $environment
        ));
    }

    /**
     * @inheritdoc
     */
    public function report($instance, $module, $file, $version, $checksum, 
                                                           $level, $message, $line) {
        return $this->sendRequest(array(
                    'method' => 'report',
                    'instance' => $instance,
                    'module' => $module,
                    'file' => $file,
                    'version' => $version,
                    'checksum' => $checksum,
                    'level' => $level,
                    'message' => $message,
                    'line' => $line,
        ));
    }

    /**
     * @inheritdoc
     */
    public function check($instance, $reportID) {
        return $this->sendRequest(array(
                    'method' => 'check',
                    'instance' => $instance,
                    'reportID' => $reportID
        ));
    }

    /**
     * @inheritdoc
     */
    public function apply($instance, $patchID) {
        return $this->sendRequest(array(
                    'method' => 'apply',
                    'instance' => $instance,
                    'patchID' => $patchID
        ));
    }
    
    /**
     * @inheritdoc
     */
    public function balance($instance) {
        return $this->sendRequest(array(
                    'method' => 'balance',
                    'instance' => $instance
        ));
    }

}