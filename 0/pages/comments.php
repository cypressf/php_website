<?php
submitCommentDelete();
$query = "SELECT comment,user_id,DATE_FORMAT(time, '%b %e') AS format_time FROM comments ORDER BY time DESC";
$result = mysql_query($query);
?>
<table id="users">
<colgroup>
<col />
<col class="comment" />
<col class="time" />
</colgroup>
<tbody>
<?php
$counter = 0;
$class = "";
while($row = mysql_fetch_array($result)):
$counter ++;
$cookie = $row["user_id"];
$time = $row["format_time"];
$user = getCookieName($cookie);
$comment = nl2br(htmlentities($row["comment"]));
if($counter%2 == 1) $class = "odd";
else $class = "even";
if(getCookieName($cookie) == "Cypress") $class.=" admin";
?>
		<tr class="<?php echo $class; ?>">
			<td><?php echo $user; ?></td>
			<td><?php echo $comment; ?></td>
			<td><?php echo $time; ?></td>
		</tr>
<?php endwhile; ?>
	</tbody>
</table>
