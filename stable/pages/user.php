<?php
login();
logout();
if(getCookie()) include("editor.php");
else include("login.php");
?>