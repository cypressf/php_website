<?php
include "functions.php";
connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo getPage(); ?></title>
</head>
<body>

<?php include("nav.php"); ?>

<?php include("pages/".getPage().".php"); ?>

</body>
</html>