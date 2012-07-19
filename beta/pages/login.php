<?php
logout();
login();

if( !getName() ):
?>
<form action="" method="get" id="login">
	<input type="hidden" name="page" value="login">
	
	<label for="name">Name:</label>
	<input type="text" name="name" id="name" maxlength="20" autofocus>
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20">
	
	<input type="submit" id="submit" value="Login" />
</form>
<?php
	else: include("comments.php");
	endif;
?>