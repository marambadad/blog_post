<?php
//Create Session
session_start();
$page_title = "Home Page";
?>
<!DOCTYPE html>
<html>
<style type="text/css">
/*this is css code */
body
{
    background-color:#F9DEEC;
}
h2
{
	color:white;
	text-align:center;
	background-color:#F993C9;
	width:500px;
	height:40px;
	align-content: center;
	margin-left:300px;
}
h3{
	color: white;
	background-color:#F993C9;
	width:500px;
	align-content: center;
	margin-left:300px;
}
h4{
	color: black;
	font-size: 16px;
	margin-left:300px;
}
</style>
<?php
//header
include('header.php');
include('mysqli_connect.php');
//If a user name is entered display login mesage
	if (isset($_SESSION['first_name'])) {
		echo "You currently logged in as {$_SESSION['first_name']}. Welcome to our website!";
}

//same page delete codes
if (isset($_GET['delete_id']) && (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 1))) {
	$delete_id = mysqli_real_escape_string($dbc, trim($_GET['delete_id']));
	
	$delete_query = "DELETE FROM blogposts WHERE blogpost_id = ". $delete_id;
	$delete_results = mysqli_query($dbc, $delete_query);
	if ($delete_results){
		echo "<h3 style=\"background-color:black; text-align:center;\">Your blogpost has been deleted.</h3><br>";
	}
	else{
		$delete_id="";
	}
	//mysqli_query($dbc, $delete_query);{
}

//PAGINATION SETUP START
//From Textbook Script 10.5 - #5
//***********************************************

// Number of records to show per page:
$display = 5;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
$pages = $_GET['p'];
} else { // Need to determine.
// Count the number of records:
$q = "SELECT COUNT(blogpost_id) FROM blogposts";
$r = mysqli_query ($dbc, $q);
$rowp = mysqli_fetch_array ($r, MYSQLI_NUM);
$records = $rowp[0];
// Calculate the number of pages...
if ($records > $display) { // More than 1 page.
$pages = ceil ($records/$display);
} else {
$pages = 1;
}
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
$start = $_GET['s'];
} else {
$start = 0;
}

//***********************************************
//PAGINATION SETUP END

//SORTING SETUP START
//From Textbook Script 10.5 - #5
//***********************************************

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'date';

// Determine the sorting order:
switch ($sort) {
case 'recent':
$order_by = 'blogpost_timestamp DESC';
break;

case 'oldest':
$order_by = 'blogpost_timestamp ASC';
break;

default:
$order_by = 'blogpost_timestamp DESC';
$sort = 'recent';
break;
}

//Sort buttons
echo '<div align="center">';
echo '<strong> Sort By: </strong>';
echo '<a href="?sort=recent">Most Recent</a>  |';
echo '<a href="?sort=oldest">Oldest</a>  |';
echo '</div>';
?>
<h2>Blogposts: </h2>
<body>
<?php
//***********************************************
//SORTING SETUP END
$query = "SELECT * FROM blogposts ORDER BY $order_by LIMIT $start, $display";
$results= mysqli_query($dbc,$query);
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
echo "<h3>";
echo $row['blogpost_title'] ." <br>";
echo $row['blogpost_body'] ." <br>";
echo $row['blogpost_timestamp'] ." <br>";
echo "Blogpost ID is " . $row['blogpost_id']. "<br><br>";
echo "<a href='viewcomments.php?blogpost_id= ".$row ['blogpost_id']."'>View Blog Post |</a>";
if (isset($_SESSION['user_id'])) {
echo "<a href='newcomment.php?blogpost_id=". $row['blogpost_id']."'> Add comment |</a>";
}
if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 1)){
echo "<a href='update.php?blogpost_id= ".$row ['blogpost_id']."'>Update Blog Post |</a>";
}
if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 1)){
echo "<a href='index.php?delete_id= ".$row ['blogpost_id']."'>Delete Blog Post |</a>";
}
echo "</h3>";
}
?>
<?php
//***********************************************
//PAGINATION PREVIOUS AND NEXT PAGE BUTTONS/LINKS START
//***********************************************

// Make the links to other pages, if necessary.
if ($pages > 1) {

echo '<br /><p>';
$current_page = ($start/$display) + 1;

// If it's not the first page, make a Previous button:
if ($current_page != 1) {
echo '<a href="?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
}

// Make all the numbered pages:
for ($i = 1; $i <= $pages; $i++) {
if ($i != $current_page) {
echo '<a href="?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
} else {
echo $i . ' ';
}
} // End of FOR loop.

// If it's not the last page, make a Next button:
if ($current_page != $pages) {
echo '<a href="?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
}

echo '</p>'; // Close the paragraph.

} // End of links section.

//***********************************************
//PAGINATION PREVIOUS AND NEXT PAGE BUTTONS/LINKS END
//***********************************************
?>
</body>
</html>
<?php
include('footer.php');
?>
