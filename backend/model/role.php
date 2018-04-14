<?php


class Role{
	private $id;
	private $person_id;
	private $type_id;

	function setId($id) { $this->id = $id; }
	function getId() { return $this->id; }
	function setPerson_id($person_id) { $this->person_id = $person_id; }
	function getPerson_id() { return $this->person_id; }
	function setType_id($type_id) { $this->type_id = $type_id; }
	function getType_id() { return $this->type_id; }	
}

class RoleType{
	private $id;
	private $name;
	private $points;

	function setId($id) { $this->id = $id; }
	function getId() { return $this->id; }
	function setName($name) { $this->name = $name; }
	function getName() { return $this->name; }
	function setPoints($points) { $this->points = $points; }
	function getPoints() { return $this->points; }

}

?>