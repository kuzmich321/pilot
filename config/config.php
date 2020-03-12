<?php

define('DEBUG', true);

define('DB_NAME', 'pilot'); // database name
define('DB_USER', 'root'); // database user
define('DB_PASSWORD', ''); // database password
define('DB_HOST', '127.0.0.1'); // database host

// default controller if there isn't one in the url
define('DEFAULT_CONTROLLER', 'HomeController');

//if no layout is set in the controller USE this one
define('DEFAULT_LAYOUT', 'default');

//set this to '/' for a server
define('PROOT', '/pilot/');

// this will be used if no title provided
define('SITE_TITLE', 'Pilot');
