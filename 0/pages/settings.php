<?php
submitPassword();
?>
<form action="cookie.php" method="get" id="admin">
	<input type="hidden" name="page" value="settings" />
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" value="<?php echo getPassword(); ?>" maxlength="20" />
	
	<input type="submit" id="submit" value="Change Password" />
</form>