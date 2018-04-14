<?php

include_once('backend/query.php');
include_once('backend/model/role.php');

class RoleRepo{
	public function create($personid, $type){
		PDOMysqlQuery::Prepared('INSERT INTO T_H_ROLE (person_id,type_id) VALUES (?,(SELECT id FROM T_H_ROLE_TYPE WHERE name=?))',array(
			$personid,
			$type
		));
	}
	
	public function getRolesByPersonId($id){
		PDOMysqlQuery::Prepared('SELECT b.name,b.points FROM T_H_ROLE AS a LEFT JOIN T_H_ROLE_TYPE AS b ON a.type_id=b.id WHERE a.person_id=?',array(
			$id
		));
		
		return PDOMysqlQuery::FetchAll();
	}
	
	public function getRoles(){
		PDOMysqlQuery::Prepared('SELECT name FROM T_H_ROLE_TYPE',array());
		
		return PDOMysqlQuery::FetchAll();
	}
}


?>