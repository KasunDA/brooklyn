<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Class for View Index Model
 *
 * @package WordPress\WP Error Fix\View
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 06/29/2012
 */
class AHM_View_Model_View_Index {

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct() {
        //keep all output in buffer
        ob_start();
    }

    /**
     * Default Handler
     *
     * @access protected
     * @param string $template
     * @return string
     */
    public function handle() {
        require_once(realpath(AHM_VIEW_TMPLDIR . '/index.phtml'));
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }

}