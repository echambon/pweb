<?php
/*
 * FILE:	/application/router.class.php
 * AUTHOR: 	echambon
 * DESC: 	routing class used to load the correct controller wrt the URL
 * NOTE: 	inspired from www.phpro.org MVC tutorial
 */

class router {
	private $registry;
	private $path;
	private $args = array();
	public 	$file;
	public 	$controller;
	public 	$action;

	function __construct($registry) {
		$this->registry = $registry;
	}
	
	function setPath($path) {
        // check if path is a directory
        if (is_dir($path) == false) {
			throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        
        // set the path
        $this->path = $path;
	}
	
	public function loader() {
		// check the route
		$this->getController();

		// if the controller is not there, try to load it as a page
		if(is_readable($this->file) == false) {
			// change the file path and controller to /page/show and set registry param to current controller
			// this will try to load /page/show/this->controller from the database
			$this->registry->param 	= $this->controller;
			$this->file 			= $this->path .'/'. 'page' . 'Controller.php';
			$this->controller 		= 'page';
			$this->action			= 'show';
		}

		// include the controller
		include $this->file;

		// a new controller class instance
		$class = $this->controller . 'Controller';
		$controller = new $class($this->registry);

		// check if the action is callable
		if(is_callable(array($controller, $this->action)) == false) {
			$action = 'index';
		} else {
			$action = $this->action;
		}
		
		// run the action
		$controller->$action();
	}
	
	public function getController() {
		// get the route from the url
		$route = (empty($_GET['rt'])) ? '' : $_GET['rt'];

		if(empty($route)) {
			$route = 'index';
		} else {
			// get the parts of the route
			$parts = explode('/', $route);
			$this->controller = $parts[0];
			if(isset($parts[1])) {
				$this->action = $parts[1];
			}
			
			// remaining part of the route, if any
			if(isset($parts[2])) {
				$this->registry->param = $parts[2];
			} else {
				$this->registry->param = '';
			}
		}

		if(empty($this->controller)) {
			$this->controller = 'page';
		}

		// Get action
		if(empty($this->action)) {
			$this->action = 'index';
		}

		// set the file path
		$this->file = $this->path .'/'. $this->controller . 'Controller.php';
	}
}
