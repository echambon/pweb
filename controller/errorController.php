<?php
/*
 * FILE:	/controller/errorController.php
 * AUTHOR: 	echambon
 * DESC: 	error controller to manage error pages
 */
 
class errorController extends baseController {
		
	private function setErrorTemplate($title, $type, $message) {
		$this->registry->template->error_title 		= $title;
		$this->registry->template->error_type 		= $type;
		$this->registry->template->error_message 	= $message;
	}
	
	public function index() {		
		// set template variables
		$this->setErrorTemplate('Undocumented error', 'Error XXX', 'Undocumented error');
		
		// load the error template
		$this->registry->template->show('error');
	}
	
	/*public function show() {		
		// set template variables
		$this->setErrorTemplate($this->registry->error->title, $this->registry->error->type, $this->registry->error->message);
		
		// load the error template
		$this->registry->template->show('error');
	}*/
	
	public function error404() {
		$this->setErrorTemplate('Page not found', 'Error 404', 'Page not found');
		
		// load the error template
		$this->registry->template->show('error');
	}
	
	public function error403() {
		$this->setErrorTemplate('Access forbidden', 'Error 403', 'Access forbidden');
		
		// load the error template
		$this->registry->template->show('error');
	}
}
