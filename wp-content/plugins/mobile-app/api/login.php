<?php

/*
* canvas-api/login endpoint
* showing custom login page
*/

// Setting up the WordPress enviroment
$root_path = preg_replace( '/wp-content(?!.*wp-content).*/', '', __DIR__ );
require_once $root_path . 'wp-load.php';
// Including the general function for the form
require_once CANVAS_DIR . 'core/form/canvas-form.class.php';
// Including specified functions for login page
require_once CANVAS_DIR . 'core/form/canvas-login.class.php';
