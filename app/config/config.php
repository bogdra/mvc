<?php

// File Root
define('ROOT', dirname(__FILE__,2));

// URL Root
define ('URL_ROOT','http://localhost/mymvc');

// Web Site Name
define ('SITE_NAME', '_Site Name_');

// sets the debug mode on or off
define('DEBUG',1);

// define the default controller 
define('DEFAULT_CONTROLLER','Home');

// define the default action
define('DEFAULT_ACTION','index'); 

// define path to file of general error logging file
define('LOG_ERROR_GENERAL_FILE',ROOT .DS. 'tmp' .DS. 'logs' .DS. 'error.log');

// define default Layout 
define('DEFAULT_LAYOUT','default');

// database credentials
define('DB_HOST','127.0.0.1');
define('DB_NAME','mymvc');
define('DB_USER','root');
define('DB_PASS','');


