<?php
/*
 * FILE:	/application/controller_base.class.php
 * AUTHOR: 	echambon
 * DESC: 	base controller class
 * NOTE: 	inspired from www.phpro.org MVC tutorial
 */
 
abstract class baseController {
	protected $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}
	
	abstract function index();
}
