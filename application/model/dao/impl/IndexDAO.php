<?php
namespace Application\Model\DAO\Impl;
use Application\Model\DAO\ApplicationDAO;

class IndexDAO extends ApplicationDAO {
	
	public function __construct() {
		$this->conn = $this->getConnection();
		
		// This override needs to be done when using multiple database. Make sure you have already stored ORACLE configuration in container.
		//$this->conn = $this->getDatabaseInstance('ORACLE'); 
		
	}
	
	public function getValues() {
		// use $this->conn, and get some values using query
		return "This message is from DAO";
	}
}