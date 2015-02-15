<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class for View Header Model
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/29/2012
 */
class AHM_View_Model_Header {

    /**
     * Instance of itself
     *
     * @access protected
     * @var AHM_View_Model_Header
     */
    protected static $_instance = NULL;

    /**
     * Type of Header
     *
     * Can be JS of CSS
     *
     * @access protected
     * @var string
     */
    protected $_type;

    /**
     * @inherit
     */
    public function handle() {
        $result = FALSE;
        switch ($this->_type) {
            case 'js':
                $result = $this->printJS();
                break;

            case 'css':
                $result = $this->printCSS();
                break;

            default:

                break;
        }

        return $result;
    }

    /**
     * Print JS
     *
     * @access protected
     * @return boolean
     */
    protected function printJS() {
        global $is_IE;

        //todo - for next release
        $prefix = (getenv('APPL_ENV') == 'development' ? '/dev' : '/dev');

        if (Router::call('Factory.isManagerScreen')) {
            Router::call(
                    'Factory.printJS',
                    array(
                        'ahm-health' => array(
                            'path' => AHM_VIEW_JSURL . $prefix . '/ahmadmin.js'
                        ),
                        'ahm-htable' => array(
                            'path' => AHM_VIEW_JSURL . '/jquery.dt.js',
                            'req' => array('jquery')
                        ),
                        'ahm-plot' => array(
                            'path' => AHM_VIEW_JSURL . '/jquery.flot.js',
                            'req' => array('jquery')
                        ),
                        'ahm-plot-time' => array(
                            'path' => AHM_VIEW_JSURL . '/jquery.flot.time.js',
                            'req' => array('jquery')
                        ),
                        'ahm-plot-pie' => array(
                            'path' => AHM_VIEW_JSURL . '/jquery.flot.pie.js',
                            'req' => array('jquery')
                        ),
                        'postbox' => array(
                            'path' => FALSE
                        ),
                        'dashboard' => array(
                            'path' => FALSE
                        )
                    )
            );
            if ($is_IE) {
                Router::call(
                        'Factory.printJS',
                        'ahm-plot-canvas',
                        AHM_VIEW_JSURL . '/excanvas.min.js'
                );
            }
            //prepare JS Localization
            $factory = Router::get('Factory');
            
            Router::call(
                    'Factory.localizeJS',
                    'ahm-health',
                    'ahmLocal',
                    array(
                        'nonce' => $factory->createAjaxNonce(),
                        'settings' => Router::call('Settings.ui'),
                        'pluginJS' => AHM_VIEW_JSURL . $prefix,
                        'statuses' => array(
                            AHM_ERROR_STATUS_NEW => $factory->lang(
                                    'Error has been captured but not reported'
                            ),
                            AHM_ERROR_STATUS_REPORTED => $factory->lang(
                                    'Error has been reported and is under review'
                            ),
                            AHM_ERROR_STATUS_FAILED => $factory->lang(
                                    'Failed to report the error'
                            ),
                            AHM_ERROR_STATUS_RESOLVED => $factory->lang(
                                    'Error has been resolved. Solution is available'
                            ),
                            AHM_ERROR_STATUS_REJECTED => $factory->lang(
                                    'Error rejected. Reason: '
                            ),
                        )
                    )
            );
        } else {
            //include extra JS for Backend Menu
            Router::call(
                    'Factory.printJS',
                    array(
                        'ahm-solution-indicator' => array(
                            'path' => AHM_VIEW_JSURL . $prefix . '/notification.js'
                        )
                    )
            );

            //prepare JS Localization
            Router::call(
                    'Factory.localizeJS',
                    'ahm-solution-indicator',
                    'ahmLocal',
                    array(
                        'nonce' => Router::call('Factory.createAjaxNonce')
                    )
            );
        }

        return TRUE;
    }

    /**
     * Print CSS
     *
     * @access protected
     * @return boolean
     */
    protected function printCSS() {
        if (Router::call('Factory.isManagerScreen')) {
            Router::call(
                    'Factory.printCSS',
                    array(
                        'ahm-health' => array(
                            'path' => AHM_VIEW_CSSURL . '/admin.css'
                        ),
                        'dashboard' => array(
                            'path' => FALSE
                        ),
                        'global' => array(
                            'path' => FALSE
                        ),
                        'wp-admin' => array(
                            'path' => FALSE
                        )
                    )
            );
        }
        //include extra css for Backend Menu
        Router::call(
                'Factory.printCSS',
                array(
                    'ahm-notifier' => array(
                        'path' => AHM_VIEW_CSSURL . '/notification.css'
                    )
                )
        );

        return TRUE;
    }

    /**
     * Get Single Instance of itself
     *
     * @access public
     * @return AHM_View_Model_Header
     */
    public static function getInstance($type) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        self::$_instance->_type = $type;

        return self::$_instance;
    }

}