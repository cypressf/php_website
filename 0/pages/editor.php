<?php
submitComment();
submitCommentDelete();
$cookie = getCookie();
$query = "SELECT comment,DATE_FORMAT(time, '%b %e') AS time,id FROM comments WHERE user_id = '$cookie' ORDER BY time DESC";
$result = mysql_query($query);
?>
<form action="cookie.php?page=user" method="post" name="commentform" id="comment">
	<textarea name="comment"></textarea>
	<input type="submit" id="submit" value="Submit" />
</form>

<table id="users">
	<thead>
		<tr>
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
?>
		<tr<?php if($counter%2 == 1) echo " class='odd'"; ?>>
			<td><?php echo nl2br(htmlentities($row["comment"])); ?></td>
			<td><?php echo $row["time"]; ?></td>
			<td><a href="?page=<?php echo getPage() ?>&delete=<?php echo $row["id"]; ?>">delete</a></td>
		</tr>
<?php endwhile; ?>
	</tbody>
</table>
