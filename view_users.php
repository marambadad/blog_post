<?php
session_start();
if (($_SESSION['user_id'] != 1)) {
	header("Location:http://mobadad@uwmsois.com/public_html/class_content/final/login.php");
}
$page_title = 'View Current Users';
include ('header.php');

// Page header:
echo '<h1>Registered Users</h1>';

require ('mysqli_connect.php'); // Connect to the db.
		
// Make the query:
$q = "SELECT CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, (email) AS email FROM users ORDER BY registration_date ASC";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registered users.</p>\n";

	// Table header.
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr><td align="left"><b>Name</b></td></td><td align="left"><b>Date Registered</b></td><td align="left"><b>Email</b></tr>
';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['name'] .  '<td align="left">' . $row['dr'] .'</td><td align="left">' . $row['email'] . '</td></tr>
		';
	}

	echo '</table>'; // Close the table.
	
	mysqli_free_result ($r); // Free up the resources.	

} else { // If no records were returned.

	echo '<p class="error">There are currently no registered users.</p>';

}

mysqli_close($dbc); // Close the database connection.

include ('footer.php');
?>