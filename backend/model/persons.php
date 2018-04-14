<?php


class PersonModel{
	private $id;
	private $first_name;
	private $second_name;
	private $phone_number;
	private $email;
	private $notes;
	private $long;
	private $lat;
	private $dist;

	function setId($id) { $this->id = $id; }
	function getId() { return $this->id; }
	function setFirstName($first_name) { $this->first_name = $first_name; }
	function getFirstName() { return $this->first_name; }
	function setSecondName($second_name) { $this->second_name = $second_name; }
	function getSecondName() { return $this->second_name; }
	function setPhoneNumber($phone_number) { $this->phone_number = $phone_number; }
	function getPhoneNumber() { return $this->phone_number; }
	function setEmail($email) { $this->email=$email; }
	function getEmail() { return $this->email; }
	function setNotes($notes) { $this->notes = $notes; }
	function getNotes() { return $this->notes; }
	function setLong($long) { $this->long = $long; }
	function getLong() { return $this->long; }
	function setLat($lat) { $this->lat = $lat; }
	function getLat() { return $this->lat; }
	function setDist($dist) { $this->dist = $dist; }
	function getDist() { return $this->dist; }
}

class PersonCreator{
	public static function from($json){
		$mapper=array(
			'id'=>'setId',
			'first_name'=>'setFirstName',
			'second_name'=>'setSecondName',
			'phone_number'=>'setPhoneNumber',
			'email'=>'setEmail',
			'notes'=>'setNotes',
			'long'=>'setLong',
			'lat'=>'setLat',
			'dist'=>'setDist'
		);
		$person=new PersonModel();
		
		foreach($json as $k=>$v){
			if(isset($mapper[$k])){
				$person->{$mapper[$k]}($v);
			}else{
				die('Unknown field: '.$k);
			}
		}
		return $person;
	}
}

?>