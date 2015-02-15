<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Abstract Email Model
 *
 * @package WordPress\WP Error Fix\Email
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 12/28/2013
 */
abstract class AHM_Email_Model_Abstract {

    /**
     * Email template
     * 
     * @var string
     * 
     * @access private 
     */
    private $_template = '';
    
    /**
     * Recipient email address
     * 
     * @var string
     * 
     * @access private 
     */
    private $_recepient = '';

    /**
     * Send email address
     * 
     * @return void
     * 
     * @access public
     */
    abstract public function send();

    /**
     * Check is recepient email address exists and is valid
     * 
     * @return boolean
     * 
     * @access public
     */
    public function can() {
        //read preferences and extract email address
        $preferences = Router::call('Settings.preference');
        if (!empty($preferences['email'])) {
            $this->setRecepient(filter_var(
                            $preferences['email'], FILTER_VALIDATE_EMAIL
            ));
        }

        return ($this->getRecepient() ? true : false);
    }

    /**
     * Replace template markers with actual data
     * 
     * @param string $template
     * 
     * @return string
     * 
     * @access public
     */
    public function replaceMarkers($template) {
        return str_replace(
                array('#WEBSITE', '#SYSTEM_ID'), 
                array(
                    Router::call('Factory.baseURL'), Router::call('Settings.account')
                ), 
                $template
        );
    }

    /**
     * Read email template from the file
     * 
     * @param string $filename
     * 
     * @return void
     * 
     * @access public
     */
    public function readTemplate($filename) {
        if (file_exists($filename)) {
            $this->setTemplate(file_get_contents($filename));
        }
    }

    /**
     * Set Recepient email address
     * 
     * @param string $recepient
     * 
     * @return void
     * 
     * @access public
     */
    public function setRecepient($recepient) {
        $this->_recepient = $recepient;
    }

    /**
     * Get Recepient email address
     * 
     * @return string
     * 
     * @access public
     */
    public function getRecepient() {
        return $this->_recepient;
    }

    /**
     * Set email template
     * 
     * @param string $template
     * 
     * @return void
     * 
     * @access public
     */
    public function setTemplate($template) {
        $this->_template = $template;
    }

    /**
     * Get email template
     * 
     * @return string
     * 
     * @access public
     */
    public function getTemplate() {
        return $this->_template;
    }

}