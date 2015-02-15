<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Email Error Model
 *
 * @package WordPress\WP Error Fix\Email
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 12/28/2013
 */
class AHM_Email_Model_Error extends AHM_Email_Model_Abstract {

    /**
     * Send Email
     * 
     * @return void
     * 
     * @access public
     */
    public function send() {
        if ($this->can()) {
            $this->readTemplate(AHM_EMAIL_TEMPLATE_DIR . '/error.txt');
            Router::call('Factory.sendEmail', array(
                'recepient' => $this->getRecepient(),
                'subject' => 'Application Error(s) Detected',
                'message' => $this->replaceMarkers($this->getTemplate()),
                'fromName' => 'WP Error Fix',
                'fromEmail' => 'support@phpsnapshot.com'
            ));
        }
    }
    
    /**
     * Extend the can function with additional check
     * 
     * @return void
     * 
     * @access public
     */
    public function can(){
        if ($response = parent::can()){
            $preferences = Router::call('Settings.preference');
            $response = (isset($preferences['notify']['error']) ? true : false);
        }
        
        return $response;
    }

}