<?php
namespace Application\Controller;
use Application\Model\Service\Impl\IndexService;

class IndexController extends ApplicationController {
	
	private $service;
	
	public function __construct() {
		parent::__construct();
		$this->service = new IndexService();
	}
	
	
	public function defaultAction($one = "", $two = "") {
		echo "From Controller";
		
		$message = "From View";
		$this->view->addObject("mesg", "<br />".$message. "<br />".$one."<br />".$two );
		$this->view->render('index');
	}
	
	public function testFromServiceAction() {
		$this->view->addObject("mesg", $this->service->testMessage());
		$this->view->render('index');
	}
	
	public function testFromDAOAction() {
		$this->view->addObject("mesg", $this->service->messageFromDAO());
		$this->view->render('index');
	}
}