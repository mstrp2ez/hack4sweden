<?php

include_once('backend/query.php');
include_once('backend/model/persons.php');
include_once('backend/repository/role.php');

class PersonsRepo{
	
	public function getPersonById($id){
		PDOMysqlQuery::Prepared('SELECT * FROM T_H_PERSON WHERE id=?',array($id));
		$person=PDOMysqlQuery::FetchAll();
		
		$roleRepo=new RoleRepo();
		$allRoles=$roleRepo->getRoles();
		
		PDOMysqlQuery::Prepared('SELECT b.name FROM T_H_ROLE AS a LEFT JOIN T_H_ROLE_TYPE AS b ON a.type_id=b.id WHERE a.person_id=?',array(
			$id
		)); 
		$activeRoles=PDOMysqlQuery::FetchAll();
		if($activeRoles==false){$activeRoles=array();}
		foreach($allRoles as $key=>$r0){
			$found=false;
			foreach($activeRoles as $r1){
				if($r0['name']==$r1['name']){
					$found=true;
				}
			}
			$r0['active']=$found;
			$allRoles[$key]=$r0;
		}
		
		
		$person[0]['roles']=$allRoles;
		return $person;
	}
	
	public function getPersons(){
		PDOMysqlQuery::Prepared('SELECT * FROM T_H_PERSON',array());
		$persons=PDOMysqlQuery::FetchAll();
		foreach($persons as $key=>$person){
			PDOMysqlQuery::Prepared('SELECT b.name FROM T_H_ROLE AS a LEFT JOIN T_H_ROLE_TYPE AS b ON a.type_id=b.id WHERE a.person_id=?',array(
				$person['id']
			));

			$activeRoles=PDOMysqlQuery::FetchAll();
			$roleRepo=new RoleRepo();
			$allRoles=$roleRepo->getRoles();			
			
			if($activeRoles==false){$activeRoles=array();}
			
			foreach($allRoles as $k=>$r0){
				$found=false;
				foreach($activeRoles as $r1){
					if($r0['name']==$r1['name']){
						$found=true;
					}
				}
				$r0['active']=$found;
				$allRoles[$k]=$r0;
			}
			
			$person['roles']=$allRoles;			
			$persons[$key]=$person;
		}
		return $persons;
	}

	public function updatePersonById($id,$person){
		
		$params='';
		$paramVals=array();
		foreach($person as $key=>$val){
			$params.="`{$key}`=?,"; 
			$paramVals[]=$val;
		}
		if(strlen($params)>0){
			$params=substr($params,0,strlen($params)-1);
		}
		$paramVals[]=$id;
		try{
		 PDOMysqlQuery::Prepared("UPDATE T_H_PERSON SET {$params} WHERE id=?",$paramVals);
		}catch (Exception $e){
			var_dump($paramVals);
			var_dump(PDOMysqlQuery::GetQuery());
		}
	}
	
	public function create(PersonModel $p_Person){
		PDOMysqlQuery::Prepared('INSERT INTO T_H_PERSON (first_name,second_name,phone_number,email,notes,lat,`long`,dist) VALUES (?,?,?,?,?,?,?,?)',array(
			$p_Person->getFirstName(),
			$p_Person->getSecondName(),
			$p_Person->getPhoneNumber(),
			$p_Person->getEmail(),
			$p_Person->getNotes(),
			$p_Person->getLat(),
			$p_Person->getLong(),
			$p_Person->getDist()
		));
		
	}
}


?>
