<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class for Error List Model
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/29/2012
 */
class AHM_View_Model_View_List {

    /**
     * Prepare Formated Error List
     *
     * @access public
     * @return array
     */
    public function handle() {
        $aaData =  array();
        foreach (Router::call('Error.errors') as $storage) {
            foreach ($storage as $hash => $info) {
                if (isset($aaData[$hash])) {
                    $aaData[$hash][1][0] = $info['last'];
                    $aaData[$hash][1][1] += $info['occured'];
                } else {
                    $aaData[$hash] = array(
                        $this->formatDetails($info),
                        array($info['last'], $info['occured']),
                        $info['status'],
                        $info['type'],
                        $info['module'],
                        (isset($info['patch']) ? $info['patch'] : ''),
                        $this->statusReason($info),
                        'DT_RowClass' => strtolower($info['type']),
                        'DT_RowId' => $hash
                    );
                }
            }
        }
        sort($aaData);

        return json_encode(
                        array(
                            'aaData' => $aaData,
                            'aaStat' => Router::call('Error.statistics')
                        )
        );
    }
    
    /**
     * Decorate the Rejected reason
     * 
     * @param array $info
     * 
     * @return string
     * 
     * @access protected
     */
    protected function statusReason($info){
        if (isset($info['reason'])){
            switch($info['reason']){
                case 4:
                    $str = 'File checksum mismatch';
                    break;
                
                case 6:
                    $str = 'Rejected by reviewer';
                    break;
                
                default:
                    $str = 'Unknown reason';
                    break;
            }
        } else {
            $str = '';
        }
        
        return $str;
    }

    /**
     * Format Error Details
     *
     * @access protected
     * @param array $info
     * @return string
     */
    protected function formatDetails($info) {
        $html = '<span class="ahm-message">' . ($info['message']) . '</span>';
        $html .= '<br/><span class="ahm-file">' . $info['relpath'] . '</span>';
        $html .= '<span class="ahm-line">(' . $info['line'] . ')</span>';

        return $html;
    }

}