<?php

//This includes the header and mysqldatabase.
$page_title = "View Comments";
include('header.php');
include('mysqli_connect.php');

//Get whatever information you need from either GET, SESSION, or POST
$blogid = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));

//Your SQL Query
$query = "SELECT * FROM comments WHERE blogpost_id =" . $blogid;
$result = mysqli_query($dbc, $query);

//Your loop to display everything
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
echo "<div class=\"w3-card-4\" style=\"width:50%;\">";
echo "<header class=\"w3-container w3-red\">";
echo "<h1>Comment for Blogpost ID" . $row['blogpost_id'] . "</h1>";
echo "</header>";
echo "<div class=\w3-container\">";
echo "<p>" . $row['comment_body'] . "</p>";
echo "</div>";
echo "<h5>" . $row['comment_timestamp'] . "</h5>";
}
