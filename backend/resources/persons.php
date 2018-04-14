<?php

include_once('backend/repository/persons.php');

class Persons{
	public function __construct($service){
		$services=array(
			'person'=>array(
				'get'=>'getPerson',
				'post'=>'createPerson'
			),
			'list'=>array(
				'get'=>'getPersons'
			),
			'update'=>array(
				'post'=>'updatePerson'
			)
		);
		
		$method=strtolower($_SERVER['REQUEST_METHOD']);
		
		if(isset($services[$service])){
			if(isset($services[$service][$method])){
				$call=$services[$service][$method];
				$this->{$call}();
			}else{
				header('HTTP/1.0 405 Method not allowed');
				die();
			}
		}
	}
	
	private function getPersonId(){
		$uri=$_SERVER['REQUEST_URI'];
		$personid=substr($uri,strrpos($uri,'/')+1);
		return $personid;
	}
	
	private function getPostBodyAsJSON(){
		$entityBody = file_get_contents('php://input');
		$json=json_decode($entityBody);
		return $json;
	}
	
	public function getPersons(){
		$personrepo=new PersonsRepo();
		$persons=$personrepo->getPersons();
		echo json_encodeUU($persons);
	}
	
	public function getPerson(){
		$personid=$this->getPersonId();
		
		$personrepo=new PersonsRepo();
		$person=$personrepo->getPersonById($personid);
		echo json_encode($person);
	}
	
	public function updatePerson(){
		$personid=$this->getPersonId();
		$json=$this->getPostBodyAsJSON();
		
		$personrepo=new PersonsRepo();
		$person=$personrepo->updatePersonById($personid,$json);
	}
	
	public function createPerson(){
		$json=$this->getPostBodyAsJSON();
		$person=PersonCreator::from($json);
		$personrepo=new PersonsRepo();
		$personrepo->create($person);
	}
}


?>