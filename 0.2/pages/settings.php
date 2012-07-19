<?php
submitPassword();
submitUserDelete();
?>
<form action="" method="get" id="settings">
	<input type="hidden" name="page" value="settings" />
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20" />
	
	<input type="submit" id="submit" value="Change Password" />
</form>

<form action="" method="get" id="settings">
	<input type="hidden" name="page" value="settings" />
	<input type="hidden" name="delete_user" value="<?php echo getCookie(); ?>" />
	
	<input type="submit" id="submit" value="Delete account" />
</form>
