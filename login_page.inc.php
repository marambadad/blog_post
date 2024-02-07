<?php # Script 12.1 - login_page.inc.php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
$sticky_email = "";
$sticky_pass = "";
include ('header.php');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Please enter the following:</h1>
	<p class="error">';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?><h1>Login</h1>
<form action="login.php" method="post">
	<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value ="<?php if (isset($_POST['email'])) echo $_POST['email']; ?><?php echo $sticky_email; ?>" ></p>
	<p>Password: <input type="password" name="pass" size="20" maxlength="20" value=" <?php if (isset($pass)) {echo $pass;}?><?php echo $sticky_pass; ?>" ></p>
	<p><input type="submit" name="submit" value="Login" /></p>
</form>
<?php include ('footer.php'); ?>