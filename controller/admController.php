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
	
	private function render($template,$scripts) {
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
		
		$scripts_str = '';
		if($scripts != NULL) {
			foreach($scripts as $script) {
				$scripts_str = $scripts_str . '<script src="/assets/js/'. $script .'.js"></script>';
			}
		}
		$this->registry->template->scripts = $scripts_str;
		
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
			$this->render('adm_index',NULL);
		}
	}
	
	public function show_login() {
		if(!isset($_SESSION['user'])) {
			// render login form
			$this->render('adm_form_login',array('jquery','adm_form_login'));
		} else {
			// "redirect" to index
			$this->index();
		}
	}
	
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
		
		echo json_encode(['error' => $error, 'message' => $message]);
	}
	
	public function logout() {
		// destroy session
		session_destroy();
		
		// redirect
		header('Location: /adm');
	}
	
	public function pages() {
		if(!isset($_SESSION['user'])) {
			$this->show_login();
		} else {
			// render pages list / creation
			$this->render('adm_pages',array('jquery','adm_pages'));
		}
	}
	
	public function process_page() {
		if(!isset($_SESSION['user'])) {
			$this->show_login();
		} else {
			$error = 1;
			$message = 'Empty mandatory fields detected.';
			
			if(!empty($_POST['pname']) && !empty($_POST['url'])) {
				// change default error message
				$error = 1;
				$message = 'A page with the same URL was found in the database.';
				
				// process posted data
				$p_name 	= htmlentities($_POST['pname']);
				$p_url		= $_POST['url'];
				$p_content	= htmlentities($_POST['content']);
				
				// check if url does not already exist in the database
				$doublon = $this->model->getPageIdByUrl($p_url);
				if(empty($doublon)) {
					$error = 0;
				}
				
				// if the page does not already exist, add it!
				if(!$error) {
					// add page to database
					$last_id = $this->model->insertPageEntry($p_name,$p_url,$p_content);
					
					// update message
					$message = 'New page created with ID #' . $last_id;
				}
			}
			
			echo json_encode(['error' => $error, 'message' => $message]);
		}
	}
	
	public function publis() {
		if(!isset($_SESSION['user'])) {
			$this->show_login();
		} else {
			// render pages list / creation
			$this->render('adm_publis',NULL);
		}
	}
}
