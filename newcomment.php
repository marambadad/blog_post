<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("Location:http://mobadad@uwmsois.com/public_html/class_content/final/login.php");
}
$page_title = "New Comment";

include('header.php');
include('mysqli_connect.php');
?>
<?php
$user_id = "";
$blogpost_id = "";
//this creates a sticky comment
$sticky_comment = "";
$user_id = mysqli_real_escape_string ($dbc, trim($_SESSION['user_id']));
$blogpost_id = mysqli_real_escape_string ($dbc, trim($_GET['blogpost_id']));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$comment_body = mysqli_real_escape_string ($dbc, trim($_POST['comment'])); //or commentbody'
	
	$query = "INSERT INTO comments(comment_id, user_id, blogpost_id, comment_body, comment_timestamp)
				VALUES ('', '$user_id', '$blogpost_id', '$comment_body', NOW())";
	//to debug
	//echo "$query";

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
    if ($comment_body == "") {
        echo "<br /><strong>Please enter a comment. </strong><br />";
    }
}
?>
<form action="newcomment.php?blogpost_id=<?php echo $blogpost_id ?>" method="POST">
<!--<form action="update.php?blogpost_id= method="POST">-->
<fieldset>
	<legend>Please enter a new comment:</legend>
	<textarea name="comment" cols="40" rows="5"> <?php if (isset($comment_body)) {echo $comment_body;}?><?php echo $sticky_comment; ?> </textarea>
	<br /><br />
	<input type="submit" name="submit" value="Submit"/>
</fieldset>