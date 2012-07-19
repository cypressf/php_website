<?php
submitComment();
submitEditComment();
submitCommentDelete();
$current_cookie = getCookie();

$query = "SELECT comment,user_id,id,deleted,DATE_FORMAT(time, '%b %e<br />%h:%i') AS format_time FROM comments ORDER BY time DESC";
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
</colgroup>

<tbody>
<?php
$counter = 0;
$class = "";
while($row = mysql_fetch_array($result)):
$cookie = $row["user_id"];
$time = $row["format_time"];
$deleted = $row["deleted"];
$user_deleted = userIsDeleted($cookie);
$user = htmlspecialchars(getCookieName($cookie));
$comment = htmlentities($row["comment"]);
$id = $row["id"];
if($counter%2 == 1) $class = "odd";
else $class = "even";
if($user == "Cypress") $class.=" admin";
?>
<?php if(!$deleted&&!$user_deleted): $counter ++; ?>
		<tr class="<?php echo $class; ?>" id="<?php echo $id ?>">
			<td><?php echo $user; ?></td>
			<td>
<?php if( isEdited($row["id"]) && getName() ): ?>
				<form action="" method="post" name="editcomment" id="editcomment">
					<input type="hidden" name="comment_id" value="<?php echo $row["id"] ?>" />
					<textarea name="editcomment"><?php echo $comment; ?></textarea>
					<input type="submit" id="submit" value="Submit" />
				</form>
<?php else: ?>
	<?php if ($cookie==$current_cookie || isAdmin()): ?>
				<ul class="controls">
					<li><a href="?page=<?php echo getPage() ?>&edit_comment=<?php echo $row["id"]; ?>#<?php echo $id ?>" class="edit">edit</a></li>
					<li><a href="?page=<?php echo getPage() ?>&delete_comment=<?php echo $row["id"]; ?>" class="delete">delete</a></li>
				</ul>
	<?php endif; ?>
	<?php echo nl2br($comment); ?>
	
<?php endif; ?>
			</td>
			<td><?php echo $time; ?></td>
		</tr>
<?php endif; ?>
<?php endwhile; ?>
	</tbody>
</table>