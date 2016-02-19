<?php
/*
 * FILE:	/controller/admController.php
 * AUTHOR: 	echambon
 * DESC: 	admin board controller
 */

class admController extends baseController {
	
	// load configuration variables
	private function configure() {
		$this->registry->template->title 		= 'Admin board';
		$this->registry->template->subtitle 	= '';
		$this->registry->template->keywords 	= $this->registry->config->keywords;
		$this->registry->template->cmsversion 	= $this->registry->config->cmsversion;
	}
	
	public function index() {
		if(!isset($_SESSION['user'])) {
			$this->show_login();
		} else {
			echo "bonjour";
		}
	}
	
	public function show_login() {
		if(!isset($_SESSION['user'])) {
			// set template variables
			$this->configure();
				
			// load the header template
			$this->registry->template->show('header');
			
			// load the menu template
			$this->registry->template->show('adm_menu');
			
			// load the page template
			$this->registry->template->show('adm_login');
			
			// set script generation end time
			$this->registry->time->setScriptEndTime(microtime(TRUE));
			$this->registry->template->gentime = $this->registry->time->getGenTime();
			
			// load footer template
			$this->registry->template->show('adm_footer');
		} else {
			$this->index();
		}
	}
	
	public function login() {
		
	}
}
