<?php
$dir = opendir("../dev");
while ($file = readdir($dir))
echo "<p><a href='".$file."'>".$file."</a></p>";
?>
