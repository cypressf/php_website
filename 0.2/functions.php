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
		$query = "SELECT name FROM people WHERE cookie = '$cookie'";
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
	$query = "SELECT id FROM people WHERE name = '$name' AND deleted = 0";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["id"];
	else return false;
}

function getNamePassword($name){
	$name = mysql_escape_string($name);
	$query = "SELECT password FROM people WHERE name = '$name' AND deleted = 0";
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
	$id = mysql_escape_string($id);
	$query = "SELECT cookie FROM people WHERE id = '$id'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["cookie"];
	else return false;
}

function getCommentCookie($id) {
	$id = mysql_escape_string($id);
	$query = "SELECT user_id FROM comments WHERE id = '$id'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row) return $row["user_id"];
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
	
	$name = $name;
	$password = $password;
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

function userIsDeleted($cookie){
	$cookie = mysql_escape_string($cookie);
	$query = "SELECT deleted FROM people WHERE cookie= '$cookie'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	return $row[0];
}

function deleteUser($cookie) {
	if($cookie == getCookie() || isAdmin() ) {
		$cookie = mysql_escape_string($cookie);
		$query = "UPDATE people SET deleted = 1 WHERE cookie= '$cookie'";
		mysql_query($query);
	}
}

function deleteComment($id) {
	if(getCommentCookie($id) == getCookie() || isAdmin() ) {
		$id = mysql_escape_string($id);
		$query = "UPDATE comments SET deleted = 1 WHERE id = '$id'";
		mysql_query($query);
	}
}

function fullDeleteUser($id) {
	$id = mysql_escape_string($id);
	$query = "DELETE FROM people WHERE id = '$id' AND deleted = 1";
	mysql_query($query);
}

function fullDeleteComment($id) {
	$id = mysql_escape_string($id);
	$query = "DELETE FROM comments WHERE deleted = 1 AND id = '$id'";
	mysql_query($query);
}

function killDeleted(){
	$query = "DELETE FROM comments WHERE deleted = 1";
	mysql_query($query);
	$query = "DELETE FROM people WHERE deleted = 1";
	mysql_query($query);
}

function submitEditComment(){
	if ( array_key_exists("editcomment",$_POST) && $_POST["editcomment"] != "" && array_key_exists("comment_id",$_POST) && $_POST["comment_id"] != "") {
		$comment = $_POST["editcomment"];
		$comment_id = $_POST["comment_id"];
		editComment($comment,$comment_id);
		$page = "location: ?page=".getPage()."#$comment_id";
		header($page);
	}
}

function editComment($comment,$comment_id){
	if( getCommentCookie($comment_id) == getCookie() || isAdmin() ) {
		$comment = mysql_escape_string($comment);
		$comment_id = mysql_escape_string($comment_id);
		$query = "UPDATE comments SET comment = '$comment' WHERE id = '$comment_id'";
		mysql_query($query);
		$query = "SELECT LAST_INSERT_ID() FROM comments";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		return $row["LAST_INSERT_ID()"];
	}
	return false;
}

function isEdited($id){
		if(array_key_exists("edit_comment",$_GET) && $_GET["edit_comment"]==$id){
			return true;
		}
		return false;
}


/*
	Changes the name of a specified user $id
	returns false if name is unavailable
*/
function changeName($id,$name) {
	$name = mysql_escape_string($name);
	$id = mysql_escape_string($id);
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
		$page = "location: ?page=".getPage();
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
		$page = "location: ?page=".getPage();
		header($page);
	}
}

function submitUserDelete(){
	if ( array_key_exists("delete_user", $_GET) ){
		$cookie = $_GET["delete_user"];
		deleteUser($cookie);
		$page = getPage();
		echo "<p id='alert'>User deleted... <a href='?page=$page&resurrect_user=$cookie'>undo</a></p>";
	}
	if ( array_key_exists("resurrect_user", $_GET) ){
		$cookie = $_GET["resurrect_user"];
		resurrectUser($cookie);
	}
}


function resurrectUser($cookie) {
	if($cookie == getCookie() || isAdmin() ) {
		$cookie = mysql_escape_string($cookie);
		$query = "UPDATE people SET deleted = 0 WHERE cookie = '$cookie'";
		mysql_query($query);
	}
}

function submitCommentDelete(){
	if ( array_key_exists("delete_comment", $_GET) ){
		$id = $_GET["delete_comment"];
		deleteComment($id);
		$page = getPage();
		echo "<p id='alert'>Comment deleted... <a href='?page=$page&resurrect_comment=$id'>undo</a></p>";
	}
	if ( array_key_exists("resurrect_comment", $_GET) ){
		$id = $_GET["resurrect_comment"];
		resurrectComment($id);
		$page = "location: ?page=".getPage()."#$id";
		header($page);
	}
}

function resurrectComment($id) {
	if(getCommentCookie($id) == getCookie() || isAdmin() ) {
		$id = mysql_escape_string($id);
		$query = "UPDATE comments SET deleted = 0 WHERE id = '$id'";
		mysql_query($query);
	}
}

function login() {
	if ( array_key_exists("name",$_GET) && $_GET["name"] != "" && array_key_exists("password", $_GET) && $_GET["password"] != ""){
		$name = mysql_escape_string($_GET["name"]);
		$typed_password = mysql_escape_string($_GET["password"]);
		$id = getNameId($name);
		$real_password = getIdPassword($id);
		$cookie = getIdCookie($id);
		$user_agent = dataMine();
		$query = "UPDATE people SET user_agent = '$user_agent' WHERE cookie = '$cookie'";
		
		if($typed_password == $real_password) {
			setcookie("cookie",$cookie,time()+3600);
			mysql_query($query);
			$page = "location: ?page=comments";
			header($page);
		}
		else echo "<p id='alert'>Login incorrect)</p>";
	}
}

function logout() {
	if (array_key_exists("logout",$_GET) && $_GET["logout"] == "true"){
		if (isset($_COOKIE["cookie"]) ) setcookie ("cookie", "", time() - 3600);
		$page = "location: ?page=".getPage();
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
	if ( array_key_exists("comment",$_POST) && $_POST["comment"] != "" && getName()) {
		$comment = $_POST["comment"];
		$cookie = getCookie();
		createComment($comment,$cookie);
		$page = "location: ?page=".getPage();
		header($page);
	}
}

function newUser() {
	if ( array_key_exists("name",$_GET) && $_GET["name"] != "" && array_key_exists("password", $_GET) && $_GET["password"] != ""){
		$name = mysql_escape_string($_GET["name"]);
		$password = mysql_escape_string($_GET["password"]);
		require_once('pages/recaptchalib.php');
		$privatekey = "6LfrjgoAAAAAALollfLjOwEd28x9P6Zdj8hAOt-r";
		$resp = recaptcha_check_answer ($privatekey,
		                                $_SERVER["REMOTE_ADDR"],
		                                $_GET["recaptcha_challenge_field"],
		                                $_GET["recaptcha_response_field"]);

		if (!$resp->is_valid) {
		  	$page = "location: ?page=".getPage();
			header($page);
			return false;
		}
		if(strlen($password) > 20 || strlen($name) > 20){
			echo "<p id='alert'>Naughty naughty...</p>";
			return false;
		}
		if( getNameId( $name ) && !userIsDeleted( getNameCookie($name) ) ) {
			echo "<p id='alert'>That username is taken. Chose another one or <a href='?page=user'>login</a>.</p>";
			return false;
		}
		else {
			$id = createUser($name, $password);
			$cookie = getIdCookie($id);
			setcookie("cookie",$cookie,time()+3600);
			$page = "location: ?page=comments";
			header($page);
		}
	}
}

function isAdmin(){
	return ( getCookieName(getCookie()) == "Cypress" );
}

function dataMine() {
	return mysql_escape_string($_SERVER["HTTP_USER_AGENT"]);
}


?>