<?php

/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Cache Model
 *
 * @package WordPress\WP Error Fix\Error
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 11/11/2013
 */
class AHM_Error_Model_Cache {

    /**
     * Keep cache of each Cache Object
     * 
     * Very important part. This is insure that __desctuct of Storage is executing
     * only once.
     * 
     * @var array
     * 
     * @access private
     * @static
     */
    private static $_registry = array();

    /**
     * Get Cache Object if exists
     * 
     * @param string $filename
     * 
     * @return AHM_Error_Model_Storage_Abstract|null
     * 
     * @access public
     * @static
     */
    public static function getCache($filename) {
        $filename = realpath($filename);
        if (!isset(self::$_registry[$filename])) {
            if (is_readable($filename)) {
                self::$_registry[$filename] = unserialize(
                        file_get_contents($filename)
                );
            } else {
                self::$_registry[$filename] = null;
            }
        }
        
        return self::$_registry[$filename];
    }

}