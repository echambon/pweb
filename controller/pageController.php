<?php
/*
 * FILE:	/controller/pageController.php
 * AUTHOR: 	echambon
 * DESC: 	page controller: loads current page from DB or return 404 error
 */

class pageController extends baseController {
	private $page_model;
	private $menu_model;
	private $subpages;

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
		
		// render subpages
		if(!empty($this->subpages)) {
			foreach($this->subpages as $subpage) {
				$this->registry->template->subpage_name = html_entity_decode($subpage['name']);
				$this->registry->template->subpage_title = html_entity_decode($subpage['title']);
				$this->registry->template->subpage_content = html_entity_decode($subpage['content']);
				$this->registry->template->show('subpage');
			}
		}
		
		// load footer template
		$this->registry->template->show('footer');
		
	}

	public function index() {
		// fetch the index page url
		$index_page_url = $this->page_model->getIndexUrl();
		
		// fetch the index page content
		$page_data = $this->page_model->getPageData($index_page_url[0]['val']);
		
		// set page name
		$this->registry->template->page_name = html_entity_decode($page_data[0]['name']);
		
		// set page title
		$this->registry->template->page_title = html_entity_decode($page_data[0]['title']);
		
		// set page content
		$this->registry->template->page_content = html_entity_decode($page_data[0]['content']);
		
		// get subpages
		$this->subpages = $this->page_model->getSubpagesData($page_data[0]['id']);
		
		// render page
		$this->render('page',array('jquery-3.2.1.min','style'));
	}
	
	public function show() {
		// load index if no page url is given
		if($this->registry->param == '') {
			$this->index();
		} else {
			// fetch page data by url
			$page_data = $this->page_model->getPageData($this->registry->param);
			
			// check if page is found
			if(empty($page_data)) {
				header('Location: /error/error404');
			} else {
				// check if page is subpage
				if($page_data[0]['parent'] != 0) {
					// TODO (redirect to page#subpage_name)
					
					// set a template variable
					$this->registry->template->content = 'test';
				} else {
					// set page name
					$this->registry->template->page_name = html_entity_decode($page_data[0]['name']);
					
					// set page title
					$this->registry->template->page_title = html_entity_decode($page_data[0]['title']);
					
					// set page content
					$this->registry->template->page_content = html_entity_decode($page_data[0]['content']);
					
					// get subpages
					$this->subpages = $this->page_model->getSubpagesData($page_data[0]['id']);
				}
				
				// render page
				$this->render('page',array('jquery-3.2.1.min','style'));
			}
		}
	}
}
