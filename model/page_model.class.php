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
	
	/*public function getIndexContent() {
		return $this->registry->db->select('pw_config',['val'],['id' => 6]);
	}*/
	
	public function getIndexUrl() {
		$index_page_id = $this->registry->db->select('pw_config',['val'],['id' => 6]);
		return $this->registry->db->select('pw_pages',['url'],['id' => (int)$index_page_id[0]['val']]);
	}
	
	public function getPageContent($url) {
		return $this->registry->db->select('pw_pages',['content'],['url' => $url]);
	}
}
