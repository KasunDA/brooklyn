<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

//define module constants
define('AHM_SETTINGS_STORAGE', 'mysql');
define('AHM_SETTINGS_UIOPT', 'ahm_ui');
define('AHM_SETTINGS_ACCOUNTOPT', 'ahm_account');
define('AHM_SETTINGS_BALANCEOPT', 'ahm_balance');
define('AHM_SETTINGS_PREFERENCEOPT', 'ahm_preference');

return new AHM_Settings_Controller;