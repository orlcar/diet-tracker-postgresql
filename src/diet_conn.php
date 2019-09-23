<?php

/*==================DISPLAY ERROR TOGGLE==================*/
// Define debug as TRUE in development environment, otherwise set to FALSE

define('DEBUG', false);
error_reporting(E_ALL);

if (DEBUG){
	// Display error messages when debugging in development environment
	ini_set('display_errors', '1');
}
else {
	// Turn off error messages in production environment
	ini_set('display_errors', '0');
}
/*========================================================*/

// Import PostgreSQL connection variables
include ("config.php");

// Postgre object-oriented connection
$conn = pg_connect("host=$host user=$username password=$password dbname=$dbname sslmode=$ssl");

// Load connection error message if connection fails
if (!$conn) {

	echo '<div class="container-fluid bg-info">';
		echo '<h3 class="text-center alert-danger">Server Connection Failed</h3>';
		echo '<br>';
		echo '<h5>There was a problem connecting to the server. Please try again later. If this problem continues, please contact the website adminstrator.</h5>';
		echo '<h5>Click on the following link to go back to the diet tracker home page.</h5>';
		echo '<br>';
		echo '<h4><a aria-label="Weblink to go to diet tracker main webpage " href="http://localhost:8000/index.php">Diet Tracker Main Webpage</a></h4>';
	echo '</div>';	
	die();

}

?>