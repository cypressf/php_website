<?php
class person{
	private $cookie;
	private $name;
	private $password;
	private $id;
	
	function __construct(){
	}
	
	function setName($newName){
		$this->name = $newName;
	}
	function getName(){
		return $this->name;
	}
	
}
class database {
	private $username;
	private $password;
	private $database;
	private $server;
	private $sql;
	
	function __construct(){
		$this->username = "cypress";
		$this->password = "[dennected24]";
		$this->database = "consequence";
		$this->server = "127.0.0.1:3306";
		$this->sql = new mysqli($this->server,$this->username,$this->password,$this->database);
	}
	
	function get_username() {
		return $this->username;
	}
	
	
}

$thing  = new database();
echo $thing->get_username();
?>