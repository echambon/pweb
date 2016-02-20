<?php
/*
 * FILE:	/controller/admController.php
 * AUTHOR: 	echambon
 * DESC: 	admin board controller
 */

class admController extends baseController {
	
	private $model;
	
	public function __construct($registry) {
		parent::__construct($registry);
		$this->model = new adm_model($this->registry); // autoloaded
	}
	
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
		if(!isset($_SESSION['user'])) {
			$this->registry->template->show('adm_menu');
		} else {
			$this->registry->template->show('adm_menu_logged');
		}
		
		// load the page template
		$this->registry->template->show($template);
		
		// set script generation end time
		$this->registry->time->setScriptEndTime(microtime(TRUE));
		$this->registry->template->gentime = $this->registry->time->getGenTime();
		
		// load footer template
		$this->registry->template->versioning = '';
		if(isset($_SESSION['user'])) {
			$this->registry->template->versioning = 'Server path: <b>'. getcwd() .'</b><br />Versions: <b>' . phpversion() . '</b> (PHP); <b>' . $this->registry->db->pdo->getAttribute(constant("PDO::ATTR_SERVER_VERSION")). '</b> (MySQL); <b>' . $this->registry->config->cmsversion . '</b> (<a href="' . $this->registry->config->pwebaddress . '" target="_blank">pweb</a> CMS)<br />';
		}
		$this->registry->template->show('adm_footer');
	}
	
	public function index() {
		if(!isset($_SESSION['user'])) {
			$this->show_login();
		} else {
			//
			$this->registry->template->username = $_SESSION['user'];
			
			// render admin board index
			$this->render('adm_index');
		}
	}
	
	public function show_login() {
		if(!isset($_SESSION['user'])) {
			// render login form
			$this->render('adm_form_login');
		} else {
			// "redirect" to index
			$this->index();
		}
	}
	
	// PROBLEM: CAN BE CALLED DIRECTLY ...
	public function process_login() {
		$error = 1;
		$message = 'Empty fields detected.';
		
		if(!empty($_POST['username']) && !empty($_POST['password'])) {
			$hash = $this->model->getPasswordByUsername($_POST['username']);
			if(empty($hash)) {
				$error = 1;
				$message = 'Username not found in database.';
			} else {
				if(password_verify($_POST['password'],$hash[0]['password'])) {
					// create session
					$_SESSION['user'] = $_POST['username'];
					
					$error = 0;
					$message = 'Welcome back <i>' . $_POST['username'] .'</i>, you are now connected!';
				} else {
					$error = 1;
					$message = 'Passwords do not match.';
				}
			}
		} else {
			header('Location: /adm');
		}
		
		//$message = 'Welcome back <i>' . $_POST['username'] .'</i>, you are now connected!';
		echo json_encode(['error' => $error, 'message' => $message]);
	}
	
	public function logout() {
		// destroy session
		session_destroy();
		
		// redirect
		header('Location: /adm');
	}
}
