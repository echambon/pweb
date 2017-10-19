<?php
/*
 * FILE:	/includes/init.php
 * AUTHOR: 	echambon
 * DESC: 	initialization file (load main classes and models)
 * NOTE: 	inspired from www.phpro.org MVC tutorial
 */

// starting session for connectivity
session_start();

// include the controller class
include __SITE_PATH . '/application/' . 'controller_base.class.php';

// include the model class
include __SITE_PATH . '/application/' . 'model_base.class.php';

// include the registry class
include __SITE_PATH . '/application/' . 'registry.class.php';

// include the router class
include __SITE_PATH . '/application/' . 'router.class.php';

// include the template class
include __SITE_PATH . '/application/' . 'template.class.php';

// include the timeManager class
include __SITE_PATH . '/application/' . 'time_manager.class.php';

// auto load model classes
function __autoload($class_name) {
	$filename = strtolower($class_name) . '.class.php';
	$file = __SITE_PATH . '/model/' . $filename;

	if (file_exists($file) == false)
	{
		return false;
	}
	
	include ($file);
}

// new registry object (to store main config variables)
$registry = new registry();

// create the database registry object
$registry->db = new medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'pweb_mvc',
	'server' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	'charset' => 'utf8',

	// [optional]
	'port' => 3306,

	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
]);

// create a new timeManager object
$registry->time = new timeManager();

// load config from database and store in $registry->config (a registry itself)
$registry->config = new registry();

// error related variables
$registry->error = new registry();

// get config values from pw_config table
$config = $registry->db->select('pw_config','val');

// load config variables in registry
$registry->config->title 		= $config[0];
$registry->config->subtitle 	= $config[1];
$registry->config->email 		= $config[2];
$registry->config->keywords 	= $config[3];
$registry->config->lastmodif 	= $config[4];
$registry->config->cmsversion 	= '0.2.0';
$registry->config->pwebaddress 	= 'http://emmanuel-chambon.fr/pweb';
