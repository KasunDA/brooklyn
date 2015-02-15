<?php
/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

//clean up the output buffer, just in case some other software made a poop
while (@ob_end_clean());

return new AHM_Ajax_Controller;