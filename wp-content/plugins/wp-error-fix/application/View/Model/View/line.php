<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class for Line Graph View
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 02/25/2013
 */
class AHM_View_Model_View_Line {

    /**
     * Prepare Formated Error List
     *
     * @access public
     * @return array
     */
    public function handle() {
        $data = Router::call('Error.statistics', 'daily');
        //set colors
        $data[0]['color'] = '#CB4B4B'; //error
        $data[1]['color'] = '#EDC240'; //warning
        $data[2]['color'] = '#AFD8F8'; //notice

        @header('Content-Type: application/json');
        
        return json_encode(array(
                    'status' => 'success',
                    'total' => Router::call('Error.errorCount'),
                    'warning' => (defined('AHM_ERROR_LOG_FAILURE') ? 1 : 0),
                    'data' => $data)
        );
    }

}