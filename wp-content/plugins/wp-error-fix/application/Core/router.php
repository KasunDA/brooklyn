<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class implements Router Pattern
 *
 * @package WordPress\WP Error Fix\Core
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/25/2012
 */
final class Router {

    /**
     * Cache Requested Modules
     *
     * @access private
     * @var array
     */
    private static $_cache = array();

    /**
     * Router Configurations
     *
     * @access private
     * @var array
     */
    private static $_conf = NULL;

    /**
     * Initialize Router
     *
     * Function is publicly accessable to be able manually specify configuration
     * array. The next list of parameters in array are required:
     * > moduleDir (string) - Path to default Module Directory
     * > delimit (string) - Delimiter between Module & Method
     * > bootstrap (string) - Default bootstrap file for Module
     *
     * @access public
     * @param string|array $conf
     * @throws Exception "Configuration can not be initialized"
     * @return boolean Return TRUE or Throw an Exception
     */
    public static function init($conf = '') {
        if (is_null(self::$_conf)) {
            //load default config set
            $d = require_once(realpath(dirname(__FILE__) . '/config.php'));
            if (is_array($conf)) {
                $_conf = $conf;
            } elseif (is_string($conf) && file_exists($conf)) {
                $_conf = require($conf);
            }
            //merge with default config
            if (isset($_conf) && is_array($_conf)) {
                self::$_conf = array_merge($d, $_conf);
            } else {
                self::$_conf = $d;
            }
        }

        return TRUE;
    }

    /**
     * Main handler
     *
     * Receives the direction path and routes the request with specified list of
     * parameters.
     * $dir is a direction path with next format [Module].[Method].
     * e.g. Dummy.index will search for Dummy Module and execute the public
     * method index in it. Magic function __call can be specified in Module's
     * controller to factory the request
     *
     * @access public
     * @param string $direction
     * @return mixed
     * @throws Exception "Module [module] does not exist"
     */
    public static function call($direction) {
        //initialize configurations
        self::init();

        //get Module & Method from $direction
        list($obj, $method) = self::parseDirection($direction);

        //call method and return result
        $args = func_get_args();

        return call_user_func_array(
                        array($obj, $method), array_slice($args, 1)
        );
    }

    /**
     * Get the Controller Object but do not make an actuall call
     *
     * @access public
     * @param string $direction
     * @return object
     */
    public static function get($direction){
         //get Module & Method from $direction
        list($obj, $method) = self::parseDirection($direction);

        return $obj;
    }

    /**
     * Parse Direction and exctruct proper Module/Method pair
     *
     * @access protected
     * @param string $direction
     * @return array
     * @throws Exception "Call Direction is empty"
     */
    protected static function parseDirection($direction) {
        //validate $direction
        if (empty($direction)) {
            Throw new Exception('Calling Direction is empty');
        }

        $chunk = explode(self::$_conf['delimit'], $direction);
        //validate only method
        $chunk[1] = (count($chunk) == 1 ? 'index' : $chunk[1]);

        return self::getModule($chunk);
    }

    /**
     * Get parsed Module/Method pair and retrieve Object/Method pair
     *
     * @access protected
     * @param array $chunk
     * @return array
     * @throws Exception
     */
    protected static function getModule(array $chunk) {
        list($module, $method) = $chunk;
        //check cache, config, default module path
        if (isset(self::$_cache[$module])) {
            $obj = self::$_cache[$module];
        } elseif (isset(self::$_conf['modules'][$module])) {
            $obj = self::includeModule(self::$_conf['modules'][$module]);
        } else {
            $file = join(
                    DIRECTORY_SEPARATOR, array(
                self::$_conf['moduleDir'],
                $module,
                self::$_conf['bootstrap'])
            );
            if (file_exists($file)) {
                $obj = require($file);
            } else {
                Throw new Exception("Module {$module} does not exist!");
            }
        }

        //validate if function can be called
        if (!is_object($obj)) {
            Throw new Exception("Module {$module} is not callable");
        } else { //cache object
            self::$_cache[$module] = $obj;
        }

        return array($obj, $method);
    }

    /**
     * Parse custom Module definition and return the instance of Module
     *
     * Currently there are two possible custom Module definitions:
     * > physical path to file
     * > WSDL URL with Web Service Description
     *
     * @access protected
     * @param string $path
     * @return object|SoapClient
     */
    protected static function includeModule($path) {
        if (file_exists($path)) { // just file
            $instance = require($path);
        } elseif (filter_var($path, FILTER_VALIDATE_URL)) { //URL is WSDL
            $instance = new SoapClient($path);
        }

        return $instance;
    }

}