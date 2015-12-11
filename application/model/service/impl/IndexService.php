<?php
namespace Application\Model\Service\Impl;
use Application\Model\Service\ApplicationService;
use Application\Model\DAO\Impl\IndexDAO;

class IndexService extends ApplicationService {
	
	private $dao;
	
	public function __construct() {
		parent::__construct();
		$this->dao = new IndexDAO();
	}
	
	public function testMessage() {
		return "This is message from Service";
	}
	
	public function messageFromDAO() {
		return $this->dao->getValues();
	}
}