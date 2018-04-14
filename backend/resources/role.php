<?php 

include_once('backend/repository/role.php');


class Roles {
	public function __construct($service){
		$services=array(
			'role'=>array(
				'get'=>'getRole',
				'post'=>'createRoleByType'
			),
			'list'=>array(
				'get'=>'getRoles'
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
	
	private function getId(){
		$uri=$_SERVER['REQUEST_URI'];
		$id=substr($uri,strrpos($uri,'/')+1);
		return $id;
	}
	
	private function getPostBodyAsJSON(){
		$entityBody = file_get_contents('php://input');
		$json=json_decode($entityBody);
		return $json;
	}
	
	public function createRoleByType(){
		$id=$this->getId();
		$json=$this->getPostBodyAsJSON();
		
		if(empty($json->name)){
			header('HTTP/1.0 403 Not allowed');
			die();
		}
		
		$repo=new RoleRepo();
		$repo->create($id,$json->name);
	}
	
	public function getRole(){
		$id=$this->getId();
		
		$repo=new RoleRepo();
		$roles=$repo->getRolesByPersonId($id);
		
		echo json_encode($roles);
	}
	
	public function getRoles(){
		$repo=new RoleRepo();
		$roles=$repo->getRoles();
		
		echo json_encode($roles);
	}
}


?>