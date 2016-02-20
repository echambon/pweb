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
	
	private function render($template) {
		// set script generation start time
		$this->registry->time->setScriptStartTime(microtime(TRUE));
		
		// set template variables
		$this->configure();
			
		// load the header template
		$this->registry->template->show('header');
		
		// load the menu template
		$this->registry->template->show('adm_menu');
		
		// load the page template
		$this->registry->template->show($template);
		
		// set script generation end time
		$this->registry->time->setScriptEndTime(microtime(TRUE));
		$this->registry->template->gentime = $this->registry->time->getGenTime();
		
		// load footer template
		$this->registry->template->show('adm_footer');
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
			// render login form
			$this->render('adm_form_login');
		} else {
			$this->index();
		}
	}
	
	public function process_login() {
		$message = 'Hello <i>' . $_POST['username'] .'</i>, you are now connected!';
		echo json_encode(['error' => 0, 'message' => $message]);
	}
}
