<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Plugger for WordPress Core
 *
 * @package WordPress\WP Error Fix\Factory
 * @author Vasyl Martyniuk <martyniuk.vasyl@gmail.com>
 * @since 07/19/2012
 */
class AHM_Factory_Model_WordPress implements AHM_Factory_Model_Interface {

    /**
     * Check if Ajax call is authorized by token
     *
     * @access public
     * @return boolean|void
     */
    public function checkAjaxReferer() {
        check_ajax_referer(AHM_FACTORY_AJAXNONCE);
    }

    /**
     * @inheritdoc
     */
    public function getEnvironment() {
        return 'WordPress';
    }

    /**
     * Create Ajax Nonce
     *
     * @access public
     * @return string
     */
    public function createAjaxNonce() {
        return wp_create_nonce(AHM_FACTORY_AJAXNONCE);
    }

    /**
     * @inheritdoc
     */
    public function getModuleInfo($file) {
        static $theme_path, $plugin_path;

        if (is_null($theme_path)) {
            $theme_path = str_replace('\\', '/', realpath(get_theme_root()));
            $plugin_path = str_replace('\\', '/', realpath(WP_PLUGIN_DIR));
        }

        if (strpos($file, $theme_path) !== FALSE) { //this is the theme
            $name = $this->getModuleName($file, $theme_path);
            $module = $this->getThemeInfo($name);
        } elseif (strpos($file, $plugin_path) !== FALSE) {
            $name = $this->getModuleName($file, $plugin_path);
            $module = $this->getPluginInfo($name);
        } else {
            $module = $this->getCoreInfo();
        }

        return $module;
    }

    /**
     * Get Single Module Name
     *
     * @access protected
     * @param string $file
     * @param string $base
     * @return string
     */
    protected function getModuleName($file, $base) {
        $chunk = explode('/', str_replace($base, '', $file));

        return $chunk[1];
    }

    /**
     * Get Complete Plugin Information Array
     *
     * @access protected
     * @staticvar array $plugins
     * @param string $name
     * @return array
     */
    protected function getPluginInfo($name) {
        static $plugins;

        $module = FALSE;
        if (is_null($plugins)) {
            if (!is_admin() && !function_exists('get_plugins')){ //load it first
                //this is required to load if cron is on and frontend runs
                require_once(ABSPATH . 'wp-admin/includes/plugin.php');
            }
            $plugins = get_plugins();
        }
        foreach ($plugins as $plugin => $meta) {
            if (strpos($plugin, $name) !== FALSE) {
                $chunk = explode('/', $plugin);
                //"count($chunk) > 1" in case of Plugin like Hello Dolly
                $path = realpath(
                        WP_PLUGIN_DIR . (count($chunk) > 1 ? "/{$chunk[0]}" : '')
                );

                $module = array(
                    'name' => $meta['Name'],
                    'version' => $meta['Version'],
                    'path' => str_replace('\\', '/', $path)
                );
                //check if signature exists
                if ($signature  = $this->getSignature($module['path'])){
                    $module['name'] = $signature;
                }
                break;
            }
        }

        return $module;
    }

    /**
     * Check if module has PHPSnapshot Signature & return it if yes
     *
     * This function might be used in future to registered modules in system.
     *
     * @param string $basedir
     *
     * @return bool|string
     *
     * @access protected
     */
    protected function getSignature($basedir){
        //check if signature exists
        $filename  = $basedir . DIRECTORY_SEPARATOR . 'phpsnapshot.sng';
        if (file_exists($filename) && is_readable($filename)){
            $signature = file_get_contents($filename);
        }else{
            $signature = false;
        }

        return $signature;
    }

    /**
     * Get Complete Theme Information Array
     *
     * @param string $name
     *
     * @return array
     *
     * @access protected
     * @staticvar array $themes
     * @global $wp_version
     */
    protected function getThemeInfo($name) {
        global $wp_version;
        static $themes;

        $module = FALSE;
        if (is_null($themes)) {
            if (version_compare($wp_version, '3.4.0', '<')){
                $themes = get_themes();
            }else{
                $themes = wp_get_themes();
            }
        }
        foreach ($themes as $theme => $meta) {
            if ($meta->get_template() == $name) {
                $module = array(
                    'name' => $meta->get('Name'),
                    'version' => $meta->get('Version'),
                    'path' => str_replace(
                            '\\', '/', realpath($meta->get_template_directory())
                    )
                );
                //check if signature exists
                if ($signature  = $this->getSignature($module['path'])){
                    $module['name'] = $signature;
                }
                break;
            }
        }

        return $module;
    }

    /**
     * Get Complete Core Information
     *
     * @access protected
     * @global string $wp_version
     * @return array
     */
    protected function getCoreInfo() {
        global $wp_version;

        return array(
            'name' => 'Core',
            'version' => $wp_version,
            'path' => $this->absPath()
        );
    }

    /**
     * Get current Screen browsed by user and check is it is Adanced Health
     * Manager screen.
     *
     * @access public
     * @return boolean
     */
    public function isManagerScreen() {
        $result = FALSE;
        $page = (isset($_GET['page']) ? $_GET['page'] : NULL);
        if ($page == AHM_ErrorFix::AHM_PAGE) {
            $result = TRUE;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function absPath() {
        return str_replace('\\', '/', realpath(ABSPATH));
    }

    /**
     * Get base site URL
     *
     * @inheritdoc
     */
    public function baseURL() {
        if ($this->isSSL()){
            $url = str_replace('http', 'https', get_option('siteurl'));
        } else {
            $url = get_option('siteurl');
        }
        
        return $url;
    }
    
    /**
     * Check if backend is under SSL
     * 
     * @return boolean
     * 
     * @access public
     */
    public function isSSL(){
        if (force_ssl_admin()){
            $response = true;
        } elseif (!empty($_SERVER['HTTPS'])){
            $response = true;
        } elseif (isset($_SERVER['REQUEST_SCHEME']) 
                        && ($_SERVER['REQUEST_SCHEME'] == 'https')){
            $response = true;
        } else {
            $response = false;
        }
        
        return $response;
    }
    
    /**
     * Get AHM Plugin base dir
     * 
     * @return string
     * 
     * @access public
     */
    public function basePluginDir() {
        return AHM_BASEDIR;
    }

    /**
     * Get system's local content dir path
     *
     * @return string
     */
    public function contentDir() {
        return WP_CONTENT_DIR;
    }

    /**
     * Print JavaScript to the header
     *
     * @access public
     * @param string|array $key
     * @param string $path
     * @param array $required
     */
    public function printJS($key, $path = '', $required = array()) {
        if (is_array($key)) {
            foreach ($key as $id => $info) {
                wp_enqueue_script(
                        $id,
                        $info['path'],
                        isset($info['req']) ? $info['req'] : array()
                );
            }
        } else {
            wp_enqueue_script($key, $path, $required);
        }
    }

    /**
     * Print CSS to the header
     *
     * @access public
     * @param string|array $key
     * @param string $path
     * @param array $required
     */
    public function printCSS($key, $path = '', $required = array()) {
        if (is_array($key)) {
            foreach ($key as $id => $info) {
                wp_enqueue_style(
                        $id,
                        $info['path'],
                        isset($info['req']) ? $info['req'] : array()
                );
            }
        } else {
            wp_enqueue_style($key, $path, $required);
        }
    }

    /**
     * Print JavaScript localization
     *
     * @access public
     * @param string $key
     * @param string $param
     * @param array $data
     */
    public function localizeJS($key, $param, $data) {
        wp_localize_script($key, $param, $data);
    }

    /**
     * @inheritdoc
     */
    public function lang($label, $domain = NULL) {
        if (is_null($domain)) {
            $domain = AHM_FACTORY_LANGDOMAIN;
        }
        return __($label, $domain);
    }

    /**
     * Get Database Prefix
     *
     * @access public
     * @global wpdb $wpdb
     * @return string
     */
    public function getDdPrefix() {
        global $wpdb;

        return $wpdb->prefix;
    }

    /**
     * Query DB
     *
     * @access public
     * @global wpdb $wpdb
     * @param string $query
     * @return mixed
     */
    public function query($query) {
        global $wpdb;

        $wpdb->query($query);

        return $wpdb->last_result;
    }

    /**
     * Get Option from DB
     *
     * @access public
     * @param string $param
     * @return mixed
     */
    public function getOption($param) {
        if (is_multisite()) {
            $result = get_blog_option(get_current_blog_id(), $param);
        } else {
            $result = get_option($param);
        }

        return $result;
    }

    /**
     * Update Blog Option
     *
     * @access public
     * @param string $param
     * @param mixed $value
     * @return boolean
     */
    public function updateOption($param, $value) {
        if (is_multisite()) {
            $result = update_blog_option(get_current_blog_id(), $param, $value);
        } else {
            $result = update_option($param, $value);
        }

        return $result;
    }

    /**
     * Delete Blog Option
     *
     * @access public
     * @param string $param
     * @return boolean
     */
    public function deleteOption($param) {
        if (is_multisite()) {
            $result = delete_blog_option(get_current_blog_id(), $param);
        } else {
            $result = delete_option($param);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function remoteRequest($url, $params = array()) {
        $res = wp_remote_post($url, array('body' => $params));

        if ($res instanceof WP_Error) {
            $result = null;
        } else {
            $result = $res['body'];
        }
        return $result;
    }
    
    /**
     * Send email
     * 
     * @param array $data
     * 
     * @return boolean
     * 
     * @access public
     */
    public function sendEmail($data) {
        return wp_mail(
            $data['recepient'], 
            $data['subject'], 
            $data['message'], 
            array("From:{$data['fromName']} <{$data['fromEmail']}>")
        );
    }

}