<?php
/*
 * FILE:	/index.php
 * AUTHOR: 	echambon
 * DESC: 	main entry point, access to all other files and folders should be forbidden
 * NOTE: 	inspired from www.phpro.org MVC tutorial
 */

// error reporting
error_reporting(E_ALL); ini_set('display_errors','on');

// site path
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

// initialize system
include 'includes/init.php';

// load the router
$registry->router = new router($registry);

// set the path to the controllers directory
$registry->router->setPath(__SITE_PATH . '/controller');

// load up the template
$registry->template = new template($registry);

// load the controller
$registry->router->loader();
