<nav>
<ul id="nav">
<?php if(isAdmin()): ?>
	<li class="red"><a href="?page=admin" <?php if(getPage()=="admin") echo " id='here'" ?>>Admin</a></li>
<?php endif; ?>
<?php if(!getCookie()): ?>
	<li><a href="?page=signup"<?php if(getPage()=="signup") echo " id='here'" ?>>Create Account</a></li>
<?php endif; ?>
	<li><a href="?page=comments"<?php if(getPage()=="comments") echo " id='here'" ?>>Comments</a></li>
<?php if(getCookie()): ?>
	<li><a href="?page=settings"<?php if(getPage()=="settings") echo " id='here'" ?>>Settings</a></li>
	<li id="logout"><a href="?page=login&logout=true">Logout <?php echo getName(); ?></a></li>
<?php endif; ?>
<?php if(!getCookie()): ?>
	<li id="login"><a href="?page=login"<?php if(getPage()=="login") echo " id='here'" ?>>Login</a></li>
<?php endif; ?>
</ul>
</nav>