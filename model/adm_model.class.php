<?php
/*
 * FILE:	/model/adm_model.class.php
 * AUTHOR: 	echambon
 * DESC: 	login model
 */
 
class adm_model extends baseModel {
	
	function __construct($registry) {
		$this->registry	= $registry;
	}

	public function getPasswordByUsername($username) {
		return $this->registry->db->select('pw_users',['password'],['username' => $username]);
	}

}
