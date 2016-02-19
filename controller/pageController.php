<?php
/*
 * FILE:	/controller/pageController.php
 * AUTHOR: 	echambon
 * DESC: 	page controller: loads current page from DB or return 404 error
 */

class pageController extends baseController {
	private $model;

	public function __construct($registry) {
		parent::__construct($registry);
		$this->model = new page_model($this->registry); // autoloaded
	}

	// load configuration variables
	private function configure() {
		$this->registry->template->title 		= $this->registry->config->title;
		$this->registry->template->subtitle 	= $this->registry->config->subtitle;
		$this->registry->template->email	 	= $this->registry->config->email;
		$this->registry->template->keywords 	= $this->registry->config->keywords;
		$this->registry->template->lastmodif 	= $this->registry->config->lastmodif;
		
		$this->registry->template->cmsversion 	= $this->registry->config->cmsversion;
		$this->registry->template->pwebaddress 	= $this->registry->config->pwebaddress;
	}

	public function index() {
		// set script generation start time
		$this->registry->time->setScriptStartTime(microtime(TRUE));
		
		//
		$this->configure();
		
		// set a template variable
		$this->registry->template->content = '<p>Function: index</p>';
		
		// load the header template
		$this->registry->template->show('header');
		
		// load the menu template
		$this->registry->template->show('menu');
				
		// load the index template
		$this->registry->template->show('page'); //index.php
		
		// set script generation end time
		$this->registry->time->setScriptEndTime(microtime(TRUE));
		$this->registry->template->gentime = $this->registry->time->getGenTime();
		
		// load footer template
		$this->registry->template->show('footer');
	}
	
	public function show() {
		// load index if no page url is given
		if($this->registry->param == '') {
			$this->index();
		} else {
			// set script generation start time
			$this->registry->time->setScriptStartTime(microtime(TRUE));
			
			// set template variables
			$this->configure();
			
			// fetch the page content by url
			$page = $this->model->getPageContent($this->registry->param);
			
			if(empty($page)) {
				header('Location: /error/error404');
			} else {
			
				// set a template variable
				$this->registry->template->content = html_entity_decode($page[0]['content']);
				
				// load the header template
				$this->registry->template->show('header');
				
				// load the menu template
				$this->registry->template->show('menu');
				
				// load the page template
				$this->registry->template->show('page');
				
				// set script generation end time
				$this->registry->time->setScriptEndTime(microtime(TRUE));
				$this->registry->template->gentime = $this->registry->time->getGenTime();
				
				// load footer template
				$this->registry->template->show('footer');
			
			}
		}
	}
}
