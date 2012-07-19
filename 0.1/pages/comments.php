<?php
submitComment();
submitCommentDelete();
$current_cookie = getCookie();

$query = "SELECT comment,user_id,id,DATE_FORMAT(time, '%b %e<br />%h:%i') AS format_time FROM comments ORDER BY time DESC";
$result = mysql_query($query);
?>
<?php if(getName()): ?>
<form action="" method="post" name="commentform" id="comment">
	<textarea name="comment"></textarea>
	<input type="submit" id="submit" value="Submit" />
</form>
<?php endif; ?>

<table id="users">

<colgroup>
<col class="user" />
<col class="comment" />
<col class="time" />
<col class="delete" />
</colgroup>

<tbody>
<?php
$counter = 0;
$class = "";
while($row = mysql_fetch_array($result)):
$counter ++;
$cookie = $row["user_id"];
$time = $row["format_time"];
$user = htmlspecialchars(getCookieName($cookie));
$comment = nl2br(htmlentities($row["comment"]));
if($counter%2 == 1) $class = "odd";
else $class = "even";
if(getCookieName($cookie) == "Cypress") $class.=" admin";
?>
		<tr class="<?php echo $class; ?>">
			<td><?php echo $user; ?></td>
			<td><?php echo $comment; ?></td>
			<td><?php echo $time; ?></td>
			<td><?php if ($cookie==$current_cookie): ?><a href="?page=<?php echo getPage() ?>&delete=<?php echo $row["id"]; ?>">delete</a><?php endif; ?></td>
		</tr>
<?php endwhile; ?>
	</tbody>
</table>
