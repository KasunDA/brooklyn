<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class for Pie Graph View
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 02/25/2013
 */
class AHM_View_Model_View_Pie {

    /**
     * The impact value on the system for Notice
     */
    const NOTICE_IMPACT = 1;

    /**
     * The impact value on the system for Warning
     */
    const WARNING_IMPACT = 6;

    /**
     * The impact value on the system for Error
     */
    const ERROR_IMPACT = 18;

    /**
     * Prepare Formated Error List
     *
     * @access public
     * @return array
     */
    public function handle() {
        //calculate the impact value
        $total = 0;
        $data = array();

        foreach (Router::call('Error.statistics', 'plugin') as $plugin => $info) {
            $value  = $info[2] * self::NOTICE_IMPACT;
            $value += $info[1] * self::WARNING_IMPACT;
            $value += $info[0] * self::ERROR_IMPACT;
            $total += $value;
            $data[] = array(
                'label' => $plugin,
                'data' => $value
            );
        }

        foreach($data as &$row){
            $row['data'] = round(($row['data'] / $total) * 100, 2);
        }

        @header('Content-Type: application/json; charset=UTF-8');

        return json_encode(array(
                    'status' => 'success',
                    'total' => Router::call('Error.errorCount'),
                    'warning' => (defined('AHM_ERROR_LOG_FAILURE') ? 1 : 0),
                    'data' => $data)
        );
    }

}