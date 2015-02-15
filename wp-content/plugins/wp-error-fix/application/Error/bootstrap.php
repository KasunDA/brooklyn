<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

define('AHM_ERROR_STORAGE', 'file');
define('AHM_ERROR_LOGSIZE', 1048576); //1MB per Day
define('AHM_ERROR_SCANLIMIT', 5000);
define('AHM_ERROR_DAYCOUNT', 14); //number of days to take in consideration
define('AHM_ERROR_DATEFORMAT', 'Y-m-d');
define('AHM_ERROR_QUEUELIMIT', 10); //number of reports to send per request
define('AHM_ERROR_STATUS_NEW', 'new');
define('AHM_ERROR_STATUS_REPORTED', 'reported');
define('AHM_ERROR_STATUS_FAILED', 'failed');
define('AHM_ERROR_STATUS_RESOLVED', 'resolved');
define('AHM_ERROR_STATUS_REJECTED', 'rejected');

return AHM_Error_Controller::getInstance();