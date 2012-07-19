<?php
submitUserDelete();
submitForm();
$query = "SELECT * FROM people ORDER BY name";
$result = mysql_query($query);
?>
<form action="cookie.php" method="get" id="admin">
	<input type="hidden" name="page" value="superduper" />
	
	<label for="name">Name:</label>
	<input type="name" name="name" id="name" maxlength="20" />
	
	
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" maxlength="20" />
	
	<input type="submit" id="submit" value="Create Account" />
</form>

<table id="users">
	<thead>
		<tr>
			<td>Id</td>
			<td>Name</td>
			<td>Password</td>
			<td>Cookie</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
<?php
$counter = 0;
while($row = mysql_fetch_array($result)):
$counter ++;
?>
		<tr<?php if($counter%2 == 1) echo " class='odd'"; ?>>
			<td><?php echo $row["id"]; ?></td>
			<td><?php echo htmlentities($row["name"]); ?></td>
			<td><?php echo htmlentities($row["password"]); ?></td>
			<td><?php echo $row["cookie"]; ?></td>
			<td><a href="?page=<?php echo getPage(); ?>&delete=<?php echo $row["id"]; ?>">delete</a></td>
		</tr>
<?php endwhile; ?>
	</tbody>
</table>

<?php
submitCommentDelete();
$query = "SELECT id,comment,time,user_id FROM comments ORDER BY time DESC";
$result = mysql_query($query);
?>
<table id="users">
	<thead>
		<tr>
			<td>User</td>
			<td>Comment</td>
			<td>Time</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
<?php
$counter = 0;
while($row = mysql_fetch_array($result)):
$counter ++;
$cookie = $row["user_id"];
$time = $row["time"];
$user = getCookieName($cookie);
$comment = nl2br(htmlentities($row["comment"]));
?>
		<tr<?php if($counter%2 == 1) echo " class='odd'"; ?>>
			<td><?php echo $user; ?></td>
			<td><?php echo $comment; ?></td>
			<td><?php echo $time; ?></td>
			<td><a href="?page=<?php echo getPage(); ?>&delete=<?php echo $row["id"]; ?>">delete</a></td>
		</tr>
<?php endwhile; ?>
	</tbody>
</table>