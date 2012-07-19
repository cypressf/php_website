<?php
include("../beta/functions.php");
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
require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Gdata_Books');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
$books = new Zend_Gdata_Books();
connect();
login();
logout();
if(getName()):
if(array_key_exists("add_book",$_GET) ) {
	addBook($_GET["add_book"],getCookie());
}
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
<form action="" method="get">
	Title:
	<input type="search" name="title">
	<input type="submit" value="search">
</form>
<?php
if(array_key_exists("title",$_GET) ) :
	$search=$_GET["title"];
	$service = 'print';
	$query = $books->newVolumeQuery();
	 $query->setQuery($search);
	 $query->setMinViewability('noview');
	 $feed = $books->getVolumeFeed($query);
?>
<table>
	<thead>
		<tr>
			<td>Title</td>
			<td>Author</td>
			<td>Subject</td>
			<td>More</td>
			<td>Library</td>
		</tr>
	</thead>
	<tbody>
<?php foreach ($feed as $entry): ?>
<?php
	$title = $entry->getTitle();
	$authors = $entry->getCreators();
	$mores = $entry->getDescriptions();
	$subjects = $entry->getSubjects();
	$id = $entry->getVolumeId();
	if(array_key_exists(0,$authors))$author = $authors[0];
	else $author = "";
	if(array_key_exists(0,$subjects))$subject = $subjects[0];
	else $subject = "";
	if(array_key_exists(0,$mores))$more = $mores[0];
	else $more = "";
	?>
		<tr<?php if(hasBook($id)) echo " class='saved'"; ?>>
			<td><?php echo $title; ?></td>
			<td><?php echo $author; ?></td>
			<td><?php echo $subject; ?></td>
			<td><?php echo $more; ?></td>
			<?php if(hasBook($id)): ?>
			<td><a href="<?php echo "?title=".$search."&remove_book=".$id; ?>">remove</td>
			<?php else: ?>
			<td><a href="<?php echo "?title=".$search."&add_book=".$id; ?>">add</td>
			<?php endif;?>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php endif; // if a search was submitted ?>
<?php else: //if there is not a cookie ?>
<?php include("../beta/pages/login.php"); ?>
<?php endif; ?>
<a href="library.php">Added Books</a>