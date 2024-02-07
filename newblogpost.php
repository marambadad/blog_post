<?php
session_start();
if (($_SESSION['user_id'] != 1)) {
	header("Location:http://mobadad@uwmsois.com/public_html/class_content/final/login.php");
}
$page_title = "New Blog Post";

include('header.php');
include('mysqli_connect.php');


?>
<?php
$user_id = "";
$blogpost_id = "";
$sticky_blogpost = "";
$sticky_blogtitle = "";
$user_id = mysqli_real_escape_string ($dbc, trim($_SESSION['user_id']));
//$blogpost_id = mysqli_real_escape_string ($dbc, trim($_GET['blogpost_id']));

if (isset($_POST['blogpost_title'])) {
	$blogpost_title = mysqli_real_escape_string ($dbc, trim($_POST['blogpost_title']));
}else{
	$blogpost_title = "";
}

if(isset($_POST['blogpost_body'])) {
	$blogpost_body = mysqli_real_escape_string ($dbc, trim($_POST['blogpost_body']));
	}else{
	$blogpost_body = "";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$blogpost_body = mysqli_real_escape_string ($dbc, trim($_POST['blogpost_body'])); //or comment'
	
	$query = "INSERT INTO blogposts(blogpost_id, user_id, blogpost_title, blogpost_body, blogpost_timestamp)
				VALUES ('', '$user_id', '$blogpost_title', '$blogpost_body', NOW())";
	//to debug
	//echo $query;
?>
<?php
$results = mysqli_query($dbc, $query);
	if ($results) {
		echo "It worked (The SQL query was run)";
	}else{
	echo "There was an error." . mysqli_error($dbc);
	}
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //checks if name was submitted. if not it displays an error
    if ($blogpost_title == "") {
        echo "<br /><strong>Please enter a title.</strong><br />";
    }
    //checks email
    if ($blogpost_body == "") {
        echo "<br /><strong>Please enter a blogpost.</strong><br />";
    }
}
?>
<form action="newblogpost.php" method="POST">
<fieldset>
<legend>Please enter a blogpost title:</legend>
	<input type="text" name="blogpost_title" cols="40" rows="5" value="<?php if (isset($blogpost_title)) {echo $blogpost_title;}?><?php echo $sticky_blogtitle; ?>" /> 
	<br /><br />
Please enter a new blogpost entry:<br />
	<textarea name="blogpost_body" cols="40" rows="5"> <?php if (isset($blogpost_body)) {echo $blogpost_body;}?><?php echo $sticky_blogpost; ?></textarea>
	<br /><br />
	<input type="submit" name="submit" value="Submit"/>
</fieldset>