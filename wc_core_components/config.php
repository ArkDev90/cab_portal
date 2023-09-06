<?php

// SETUP CONFIG
define('HTTPS', true);
define('DEBUGGING', true);
define('AUTO_LOGIN', true);

// PHP CONFIG
error_reporting(E_ALL);
ini_set('display_errors', (DEBUGGING ? 1 : 0));
ini_set('memory_limit', '64M');
ini_set('session.gc_maxlifetime', 3600);

// TIMEZONE CONFIG
$timezone = "Asia/Manila";
date_default_timezone_set($timezone);

ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/var/cpanel/php/sessions/ea-php56/'));
// SESSION CONFIG
session_start();
session_set_cookie_params(3600);
session_cache_limiter('private');
session_cache_expire(3600);


// DATABASE CONFIG
//define('WC_HOSTNAME', '180.232.152.234');
define('WC_HOSTNAME', '10.0.0.10');
define('WC_USERNAME', 'portal_user');
define('WC_PASSWORD', '%N3wL@rky90!');
define('WC_DATABASE', 'cabgov_portal_cid_new');

?>