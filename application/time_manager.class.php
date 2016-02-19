<?php
/*
 * FILE:	/application/timeManager.class.php
 * AUTHOR: 	echambon
 * DESC: 	class to manage functionalities related to time
 */
 
class timeManager {
	private $scriptStartTime;
	private $scriptEndTime;

	function __construct() {
		$this->scriptStartTime = microtime(TRUE);
		$this->scriptEndTime = microtime(TRUE);
	}
	
	public function setScriptStartTime($time) {
		$this->scriptStartTime = $time;
	}
	
	public function setScriptEndTime($time) {
		$this->scriptEndTime = $time;
	}
	
	public function getGenTime() {
		return number_format(1000*($this->scriptEndTime - $this->scriptStartTime), 0);
	}
}
