<?php
newUser();
?>
<form action="cookie.php" method="get" id="admin">
	<input type="hidden" name="page" value="admin" />
	
	<label for="name">Name:</label>
	<input type="name" name="name" id="name" maxlength="20" />
	
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20" />
	
	<input type="submit" id="submit" value="Create Account and Login" />
</form>