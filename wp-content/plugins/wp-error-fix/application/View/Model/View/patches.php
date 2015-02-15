<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class for Patch List Model
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/04/2013
 */
class AHM_View_Model_View_Patches {

    /**
     * Prepare Formated Error List
     *
     * @access public
     * @return array
     */
    public function handle() {
        $aaData = array();
        foreach (Router::call('Error.errors') as $storage) {
            foreach ($storage as $report) {
                if ($report['status'] == AHM_ERROR_STATUS_RESOLVED) {
                    $aaData[$report['patch']] = array(
                        $report['patch'],
                        sprintf('ID%04s', $report['patch']),
                        (floatval($report['price']) ? $report['price'] : 'Free'),
                        0,
                        '',
                        'DT_RowId' => 'patch_' . $report['patch']
                    );
                }
            }
        }
        sort($aaData);

        return json_encode(array('aaData' => $aaData));
    }

}