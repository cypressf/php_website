<?php
$cookie_time = 3600;
function connect() {
	$server = "127.0.0.1:3306";
	$username = "cypress";
	$password = "[dennected24]";
	$database = "consequence";
	mysql_connect($server, $username, $password);
	mysql_select_db($database);
	return true;
}

function getCookie(){
	if (isset($_COOKIE["cookie"]) ) return mysql_escape_string($_COOKIE["cookie"]);
	else return false;	
}

function getId(){
	if ($cookie = getCookie() ) {
		$query = "SELECT id FROM people WHERE cookie = '$cookie'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
	
		if($row) return $row["id"];
		else return false;
	}
	else return false;
	
}

function getName(){
	if ($cookie = getCookie() ) {
		$query = "SELECT name FROM people WHERE cookie = $cookie";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$name = htmlspecialchars($row["name"]);
	}
	else {
		$name = false;
	}
	return $name;
}

function getPassword(){
	if ($id = getId()){
		$query = "SELECT password FROM people WHERE id = $id";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$password = htmlspecialchars($row["password"]);
	}
	else {
		$password = false;
	}
	return $password;
}

function getNameId($name){
	$name = mysql_escape_string($name);
	$query = "SELECT id FROM people WHERE name = '$name'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["id"];
	else return false;
}

function getNamePassword($name){
	$name = mysql_escape_string($name);
	$query = "SELECT password FROM people WHERE name = '$name'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["password"];
	else return false;
}

function getIdName($id){
	$query = "SELECT name FROM people WHERE id = '$id'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["name"];
	else return false;
}

function getCookieName($cookie){
	$query = "SELECT name FROM people WHERE cookie = '$cookie'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["name"];
	else return false;
}

function getIdPassword($id){
	$query = "SELECT password FROM people WHERE id = '$id'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["password"];
	else return false;	
}

function getIdCookie($id){
	$query = "SELECT cookie FROM people WHERE id = '$id'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["cookie"];
	else return false;
}

/*
	Creates a new user and returns it's ID
	if $name already exists, returns ID of existing user
	if $password is specified, but name is not, creates a user with a NULL name
	if $password and name are specified, creates user with specified password
*/
function createUser($name, $password){
	if($name=="" && $password=="") return false;
	if($id = getNameId($name) ) return $id; // if the user already exists, don't make it
	
	$name = mysql_escape_string($name);
	$password = mysql_escape_string($password);
	$cookie = "'" . randomString() . "'";
	
	// these insure that NULL values are submitted to mysql if empty strings
	if ($name) $name = "'" . $name . "'";
	else $name = "NULL";
	if ($password) $password = "'" . $password . "'";
	else $password = "NULL";
	
	$query = "INSERT INTO people (name,password,cookie) VALUES($name,$password,$cookie)";
	mysql_query($query);
	$query = "SELECT LAST_INSERT_ID() FROM people";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	return $row["LAST_INSERT_ID()"];
}

function createComment($comment, $cookie){
	
	$comment = mysql_escape_string($comment);

	$query = "INSERT INTO comments (comment,user_id) VALUES('$comment','$cookie')";
	mysql_query($query);
	$query = "SELECT LAST_INSERT_ID() FROM comments";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	return $row["LAST_INSERT_ID()"];
}

function deleteUser($id) {
	if ( getIdName($id) ){
		$query = "DELETE FROM people WHERE id = '$id'";
		mysql_query($query);
	}
}

function deleteComment($id) {
	$user_id = getCookie();
	$query = "DELETE FROM comments WHERE id = '$id' AND user_id = '$user_id'";
	mysql_query($query);
}

/*
	Changes the name of a specified user $id
	returns false if name is unavailable
*/
function changeName($id,$name) {
	$name = mysql_escape_string($name);
	if( getNameId($name) ) return false; // If name is already in use, we can't use it
	else {
		$query = "UPDATE people SET name = '$name' WHERE id = '$id'";
		mysql_query($query);
		return true;
	}
}

/*
	Changes the password of a specified user $id
	returns false if unsucessful
*/
function changePassword($id,$password) {
	$password = mysql_escape_string($password);
	$query = "UPDATE people SET password = '$password' WHERE id = '$id'";
	mysql_query($query);
	return true;
}

function submitForm(){
	if ( array_key_exists("name",$_GET) && $_GET["name"] != "" && array_key_exists("password", $_GET) && $_GET["password"] != ""){
		$name = $_GET["name"];
		$password = $_GET["password"];
		if(strlen($password) > 20 || strlen($name) > 20){
			echo "<p>Naughty naughty...</p>";
			return false;
		}
		if( $id = getNameId( $name ) ) {
			changePassword($id, $password);
		}
		else {
			createUser($name, $password);
		}
		$page = "location: cookie.php?page=".getPage();
		header($page);
	}
}

function submitPassword(){
	if ( array_key_exists("password", $_GET) && $_GET["password"] != ""){
		$password = $_GET["password"];
		if(strlen($password) > 20 || strlen($name) > 20){
			echo "<p>Naughty naughty...</p>";
			return false;
		}
		$id = getId();
		changePassword($id, $password);
		$page = "location: cookie.php?page=".getPage();
		header($page);
	}
}

function submitUserDelete(){
	if ( array_key_exists("delete", $_GET) ){
		$id = $_GET["delete"];
		deleteUser($id);
		$page = "location: cookie.php?page=".getPage();
		header($page);
	}
}

function submitCommentDelete(){
	if ( array_key_exists("delete", $_GET) ){
		$id = $_GET["delete"];
		deleteComment($id);
		$page = "location: cookie.php?page=".getPage();
		header($page);
	}
}

function login() {
	if ( array_key_exists("name",$_GET) && $_GET["name"] != "" && array_key_exists("password", $_GET) && $_GET["password"] != ""){
		$name = mysql_escape_string($_GET["name"]);
		$typed_password = mysql_escape_string($_GET["password"]);
		$id = getNameId($name);
		$real_password = getIdPassword($id);
		$cookie = getIdCookie($id);
		
		if($typed_password == $real_password) {
			setcookie("cookie",$cookie,time()+3600);
			$page = "location: cookie.php?page=".getPage();
			header($page);
		}
		else echo "<p id='bad'>NO BAD COOKIE (login incorrect)</p>";
	}
}

function logout() {
	if (array_key_exists("logout",$_GET) && $_GET["logout"] == "true"){
		if (isset($_COOKIE["cookie"]) ) setcookie ("cookie", "", time() - 3600);
		$page = "location: cookie.php?page=".getPage();
		header($page);
	}
}

function randomString() {
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$max = strlen($characters)-1;
	$string ="";

	for($i = 0; $i < 20; $i++) {
		$string .= $characters{mt_rand(0,$max)};
	}
	return $string;
}

function getPage(){
	if ( !array_key_exists("page",$_GET) ) $_GET["page"] = "comments";
	$page = $_GET["page"];
	return $page;
}

function submitComment(){
	if ( array_key_exists("comment",$_POST) && $_POST["comment"] != ""){
		$comment = $_POST["comment"];
		$cookie = getCookie();
		createComment($comment,$cookie);
		$page = "location: cookie.php?page=".getPage();
		header($page);
	}
}

function newUser() {
	if ( array_key_exists("name",$_GET) && $_GET["name"] != "" && array_key_exists("password", $_GET) && $_GET["password"] != ""){
		$name = mysql_escape_string($_GET["name"]);
		$password = mysql_escape_string($_GET["password"]);
		if(strlen($password) > 20 || strlen($name) > 20){
			echo "<p id='alert'>Naughty naughty...</p>";
			return false;
		}
		if( $id = getNameId( $name ) ) {
			echo "<p id='alert'>That username is taken. Chose another one or <a href='?page=user'>login</a>.</p>";
			return false;
		}
		else {
			$id = createUser($name, $password);
			$cookie = getIdCookie($id);
			setcookie("cookie",$cookie,time()+3600);
			$page = "location: ?page=user";
			header($page);
		}
	}
}

function isAdmin(){
	return ( getCookieName(getCookie()) == "Cypress" );
}

?>