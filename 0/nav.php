<ul id="nav">
<?php if( getCookieName( getCookie() ) == "Cypress" ): ?>
	<li class="red"><a href="?page=Jidj09jwjjLj3jSII3jkj2093j" <?php if(getPage()=="Jidj09jwjjLj3jSII3jkj2093j") echo " id='here'" ?>>Admin</a></li>
<?php endif; ?>
<?php if(!getCookie()): ?>
	<li><a href="?page=admin"<?php if(getPage()=="admin") echo " id='here'" ?>>Create Account</a></li>
<?php endif; ?>
	<li><a href="?page=comments"<?php if(getPage()=="comments") echo " id='here'" ?>>Comments</a></li>
<?php if(getCookie()): ?>
	<li><a href="?page=user"<?php if(getPage()=="user") echo " id='here'" ?>>Compose</a></li>
	<li><a href="?page=settings"<?php if(getPage()=="settings") echo " id='here'" ?>>Settings</a></li>
	<li id="logout"><a href="?page=user&logout=true">Logout</a></li>
<?php endif; ?>
<?php if(!getCookie()): ?>
	<li id="login"><a href="?page=user"<?php if(getPage()=="user") echo " id='here'" ?>>Login</a></li>
<?php endif; ?>
</ul>