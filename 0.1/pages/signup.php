<?php
newUser();
require_once('recaptchalib.php');
$publickey = "6LfrjgoAAAAAAN64QJwrAHj9dJexY88hO0YrE2AU";

$privatekey = "6LfrjgoAAAAAALollfLjOwEd28x9P6Zdj8hAOt-r";
?>
<script>
var RecaptchaOptions = {
   theme: 'custom',
   lang: 'en',
   custom_theme_widget: 'captcha'
};
</script>
<form action="" method="get" id="signup">
	<input type="hidden" name="page" value="signup" />
	
	<label for="name">Name:</label>
	<input type="name" name="name" id="name" maxlength="20" />
	
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20" />
	
	<label for="recaptcha_response_field">Copy these two words:</label>
	<div id="captcha">
		<div id="recaptcha_image"></div>
		<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
		<?php echo recaptcha_get_html($publickey); ?>
	</div>
	
	<input type="submit" id="submit" value="Create Account and Login" />
</form>