<?php
/*
 * FILE:	/application/registry.class.php
 * AUTHOR: 	echambon
 * DESC: 	object used to securely hold variables
 * NOTE: 	inspired from www.phpro.org MVC tutorial
 */

class registry {
	private $vars = array();

	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}

	public function __get($index)
	{
		return $this->vars[$index];
	}
}
