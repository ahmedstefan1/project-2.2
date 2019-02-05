<?php

// ########################################################################
// ########################   CONNECTION SCRIPT	  #########################
// ########################################################################

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "home_server";

// Start a connection with the database
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check if a connection with the database has been set
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_errno() . ")");
}

// ########################################################################
// ##########################	LOGIN SCRIPT	###########################
// ########################################################################

$return_msg = "";

// Check if the webpage has been called correctly
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {

	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	$query = "SELECT * FROM users WHERE BINARY username ='$username' AND BINARY password='$password'";

	$result = mysqli_query($con, $query) or die("Error: " . mysqli_error());

	if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)) {
			$privilege = $row['privilege'];
		}

		// Redirect to secured webpage
		if($privilege == 0) { // Check if privilege of user is 0 (user)
			session_start();
			$_SESSION["user_id"]=$username;
			header("Location: stations.php");
		} else if($privilege == 1) { // Check if privilege of user is 1 (admin)
			session_start();
			$_SESSION["admin_id"]=$username;
			header("Location: stations.php");
		}
	} else {
		// Wanneer geen geldig gebruikersnaam en wachtwoord gevonden, weergeef foutmelding
		$return_msg = '</br><span style="color:#ff0000">Username and password do not match</span>';
	}
}

?>
