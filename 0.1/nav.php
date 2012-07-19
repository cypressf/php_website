<ul id="nav">
	<li id="version">Version 0.1: Pine</li>
<?php if( getCookieName( getCookie() ) == "Cypress" ): ?>
	<li class="red"><a href="?page=Jidj09jwjjLj3jSII3jkj2093j" <?php if(getPage()=="Jidj09jwjjLj3jSII3jkj2093j") echo " id='here'" ?>>Admin</a></li>
<?php endif; ?>
<?php if(!getCookie()): ?>
	<li><a href="?page=signup"<?php if(getPage()=="signup") echo " id='here'" ?>>Create Account</a></li>
<?php endif; ?>
	<li><a href="?page=comments"<?php if(getPage()=="comments") echo " id='here'" ?>>Comments</a></li>
<?php if(getCookie()): ?>
	<li><a href="?page=settings"<?php if(getPage()=="settings") echo " id='here'" ?>>Settings</a></li>
	<li id="logout"><a href="?page=user&logout=true">Logout <?php echo getName(); ?></a></li>
<?php endif; ?>
<?php if(!getCookie()): ?>
	<li id="login"><a href="?page=user"<?php if(getPage()=="user") echo " id='here'" ?>>Login</a></li>
<?php endif; ?>
</ul>