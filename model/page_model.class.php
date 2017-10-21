<?php
/*
 * FILE:	/model/page_model.class.php
 * AUTHOR: 	echambon
 * DESC: 	page model controller
 */
 
class page_model extends baseModel {
	
	function __construct($registry) {
		$this->registry	= $registry;
	}
	
	public function getIndexUrl() {
		return $this->registry->db->select('pw_config',['val'],['id' => 6]);
	}
	
	public function getPageContent($url) {
		return $this->registry->db->select('pw_pages',['content'],['url' => $url]);
	}
}
