<?php
/*
 * FILE:	/controller/pageController.php
 * AUTHOR: 	echambon
 * DESC: 	page controller: loads current page from DB or return 404 error
 */

class pageController extends baseController {
	private $page_model;
	private $menu_model;

	public function __construct($registry) {
		parent::__construct($registry);
		$this->page_model = new page_model($this->registry);
		$this->menu_model = new menu_model($this->registry);
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

	private function render($template,$scripts) {
		// set script generation start time
		$this->registry->time->setScriptStartTime(microtime(TRUE));
		
		//
		$this->configure();
		
		// load javascripts
		$scripts_str = '';
		if($scripts != NULL) {
			foreach($scripts as $script) {
				$scripts_str = $scripts_str . '<script src="/assets/js/'. $script .'.js"></script>';
			}
		}
		$this->registry->template->scripts = $scripts_str;
		
		// load the header template
		$this->registry->template->show('header');
		
		// set menu template variables
		$this->registry->template->menu = '<li><a href="/">Home</a></li>';
		
		// load the menu template
		$this->registry->template->show('menu');
		
		// load the main template
		$this->registry->template->show($template);
		
		// set script generation end time
		$this->registry->time->setScriptEndTime(microtime(TRUE));
		$this->registry->template->gentime = $this->registry->time->getGenTime();
		
		// load footer template
		$this->registry->template->show('footer');
		
	}

	public function index() {
		$content = $this->page_model->getIndexContent();
		
		// set a template variable
		$this->registry->template->content = html_entity_decode($content[0]['val']);
		
		// render page
		$this->render('index',array('jquery-3.2.1.min','style'));
	}
	
	public function show() {
		// load index if no page url is given
		if($this->registry->param == '') {
			$this->index();
		} else {	
			// fetch the page content by url
			$page = $this->page_model->getPageContent($this->registry->param);
			
			if(empty($page)) {
				header('Location: /error/error404');
			} else {
				// set a template variable
				$this->registry->template->content = html_entity_decode($page[0]['content']);
				
				// render page
				$this->render('page',array('jquery-3.2.1.min','style'));
			}
		}
	}
}
