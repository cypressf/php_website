<?php
submitPassword();
?>
<form action="" method="get" id="settings">
	<input type="hidden" name="page" value="settings" />
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20" />
	
	<input type="submit" id="submit" value="Change Password" />
</form>