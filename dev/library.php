<?php
include("../beta/functions.php");
connect();
login();
logout();
	$user_id = getCookie();

function addBook($book_id, $user_id){
	$title="title";
	$author="author";
	$query = "INSERT INTO books (title,isbn,author,user_id) VALUES('$title','$book_id','$author','$user_id')";
	mysql_query($query);
}
function removeBook($book_id, $user_id){
	$query = "DELETE FROM books WHERE isbn='$book_id' AND user_id='$user_id'";
	mysql_query($query);
}
function userHasBook($user_id,$book_id){
	$query = "SELECT * FROM books WHERE isbn='$book_id' AND user_id='$user_id'";
	$result = mysql_query($query);
	return mysql_fetch_array($result);
}
function hasBook($book_id){
	$user_id = getCookie();
	return userHasBook($user_id,$book_id);
}

if(getName()):
if(array_key_exists("remove_book",$_GET) ) {
	removeBook($_GET["remove_book"],getCookie());
}
?>
<style>
table{
	border-collapse:collapse;
}
tr{
	border-bottom: 1px solid #000;
}
tr.saved{
	background:#85FF53;
}
td{
	padding:.5em;
}
thead{font-weight:bold;}
</style>
<a href="?logout=true">logout</a>
<table>
	<thead>
		<tr>
			<td>Title</td>
			<td>Author</td>
			<td>Id</td>
			<td>Library</td>
		</tr>
	</thead>
	<tbody>
<?php
$query = "SELECT * FROM books WHERE user_id='$user_id'";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)):
	$title = $row["title"];
	$authors = $row["author"];
	$id = $row["isbn"];
?>
		<tr<?php if(hasBook($id)) echo " class='saved'"; ?>>
			<td><?php echo $title; ?></td>
			<td><?php echo $authors; ?></td>
			<td><?php echo $id; ?></td>
			<?php if(hasBook($id)): ?>
			<td><a href="<?php echo "?remove_book=".$id; ?>">remove</td>
			<?php else: ?>
			<td><a href="<?php echo "?add_book=".$id; ?>">add</td>
			<?php endif;?>
		</tr>
<?php endwhile; ?>
	</tbody>
</table>
<?php else: //if there is not a cookie ?>
<?php include("../beta/pages/login.php"); ?>
<?php endif; ?>