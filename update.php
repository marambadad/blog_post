<?php
session_start();
if (!isset($_SESSION['user_id']) OR $_SESSION['user_id'] != 1) {
	header("Location:http://mobadad@uwmsois.com/public_html/class_content/final/login.php");
}
$page_title="Update";
include('header.php');
include('mysqli_connect.php');
$sticky_blogpost = "";
?>
<?php
$user_id = mysqli_real_escape_string ($dbc, trim($_SESSION['user_id']));
if (isset($_GET['blogpost_id'])){
	$blogpost_id= mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));
	}else{
		$blogpost_id = "";
	}
//if (isset($_POST['blogpost_body'])){
//	$blogpost_body = mysqli_real_escape_string($dbc, trim($_POST['blogpost_body']));
//	}else{
//		$blogpost_body = "";
//	}
	
if ($_SERVER['REQUEST_METHOD']=='POST'){
	if (isset($_POST['blogpost_title'])){
		$blogpost_title = mysqli_real_escape_string($dbc, trim($_POST['blogpost_title']));
			}else{
				$blogpost_title = "";
			}
if (isset($_POST['blogpost_body'])){
	$blogpost_body = mysqli_real_escape_string($dbc, trim($_POST['blogpost_body']));
	}else{
		$blogpost_body = "";
}
	//$query = "UPDATE blogposts SET blogpost_body= '$comment' WHERE blogpost_body = '$blogpost_body'";
	$query = "UPDATE blogposts SET blogpost_title= '$blogpost_title', blogpost_body = '$blogpost_body' WHERE blogpost_id = $blogpost_id";
	$results= mysqli_query($dbc,$query);
	if($results){
		echo "It worked. the sql query was run";
	} else{
		echo "There was an error" . mysqli_error($dbc);
	}
	if ($blogpost_id == "") {
		echo "<br /><strong>Please enter a blogpost id.</strong><br />";
	}
	if ($blogpost_body == "") {
		echo "<br /><strong>Please enter a new blogpost.</strong><br />";
	}
}	
?>
<?php
//pull in original data
if(isset($blogpost_id)){
	$sticky_query = "SELECT * FROM blogposts WHERE blogpost_id=" . $blogpost_id;
	$sticky_results = mysqli_query($dbc, $sticky_query);
	$sticky_row = mysqli_fetch_array($sticky_results, MYSQLI_ASSOC);
	$sticky_blogpost = $sticky_row['blogpost_body'];
	$sticky_blogtitle = $sticky_row['blogpost_title'];
}

?>
<form action="update.php?blogpost_id=<?php echo $blogpost_id;?>" method="POST">
<fieldset>
	<legend>Please enter your UPDATED blogpost entry:</legend>
	Please enter new title: <br />
	<input name="blogpost_title" type="text" value="<?php if (isset($blogpost_title)) {echo $blogpost_title;}?><?php echo $sticky_blogtitle?>" />
	<br /><br />
	Please enter new blogpost:<br />
	<textarea name="blogpost_body" cols="40" rows="5"> <?php echo $sticky_blogpost; ?> </textarea>
	<br /><br />
	<input type="submit" name="submit" value="Submit"/>
</fieldset>
<br>
<?php include('footer.php'); ?>