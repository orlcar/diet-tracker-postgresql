<?php

$errors = array();		// Array to hold validation errors
$data	= array();		// Array to pass back data

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

// Validation check -- add an error to $errors array if validation check fails

	// Validate filled name field
	if (empty($_POST['name'])){
		$errors['name'] = 'Name is required.';
		}

	// Validate date and allow empty field
	if (!preg_match('/^((19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01]))?$/',$_POST['date'])) {
		$errors['date'] = 'Invalid date.';
		}

	// Validate time and allow empty field
	if (!preg_match('/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)?$/',$_POST['time'])) {
		$errors['time'] = 'Invalid time.';
		}

	// Validate float and allow empty field
	if (!preg_match('/^(?:[1-9]\d*|0)?(?:\.\d+)?$/',$_POST['weight_kg'])) {
		$errors['weight_kg'] = 'Only positive numbers allowed.';
		}

	// Validate integer and allow empty field
	if (!preg_match('/^(?:[1-9]\d*|0)?$/',$_POST['calories'])) {
		$errors['calories'] = 'Only positive integers allowed.';
		}

	if (!preg_match('/^(?:[1-9]\d*|0)?$/',$_POST['fat_g'])) {
		$errors['fat_g'] = 'Only positive integers allowed.';
		}

	if (!preg_match('/^(?:[1-9]\d*|0)?$/',$_POST['carbs'])) {
		$errors['carbs'] = 'Only positive integers allowed.';
		}

	if (!preg_match('/^(?:[1-9]\d*|0)?$/',$_POST['proteins_g'])) {
		$errors['proteins_g'] = 'Only positive integers allowed.';
		}

// Return a response

	// If errors array contains errors, return error messages and skip connecting to PostgreSQL server
	if ( ! empty($errors)) {

		$data['validation'] = false;
		$data['errors']  = $errors;
	} else {

		// Import PostgreSQL connection variables
		include ("config.php");

		// Connect to PostgreSQL server
		$conn = pg_connect("host=$host user=$username password=$password dbname=$dbname");

		// Check connection	
		if(!$conn){

			die();

		} else {
			
			// Parameter preparation
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

			$intakeid = $_POST['intakeid'];

			$date = $_POST['date'];

			$time = $_POST['time'];

			$weight_kg = $_POST['weight_kg'];

			$calories = $_POST['calories'];

			$fat_g = $_POST['fat_g'];

			$carbs = $_POST['carbs'];

			$proteins_g = $_POST['proteins_g'];

			$comments = $_POST['comments'];

		// Prepare insert query and statement
		$sql = "INSERT INTO FoodIntake (Name, IntakeID, Date, Time, Weight_kg, Calories, Fat_g, Carbs, Proteins_g, Comments)
		VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";

		if($stmt = pg_prepare($conn, "insert_query", $sql)){

			// Execute the prepared statement. Will return AJAX failure message if statement execution fails
			if($stmt = pg_execute($conn, "insert_query", 
			array($name, $intakeid, $date, $time, $weight_kg, $calories, $fat_g, $carbs, $proteins_g, $comments))){

				// Check if insert query successfully created record
				if(pg_affected_rows($stmt) === 1)  {

					// Success message
					$data['validation'] = true;
					$data['message'] = 'Successful record creation!';

				} else if(pg_affected_rows($stmt) === 0)  {

					// No record was created
					$data['validation'] = true;
					$data['message'] = 'Error: Record was not created.';

				} else{

					// Generic error message
					$data['validation'] = true;
					$data['message'] = 'Unexpected error.';

				}

			} else{

				// Invalid form entries error message
				$data['validation'] = true;
				$data['message'] = 'There was an error in the form. Record was not created. Please check your form values.';
			}

		} else{

			// Query format error message
			$data['validation'] = true;
			$data['message'] = 'Query could not be processed. Please contact system administrator.';
			echo json_encode($data); 
			die();

		}

		// Free the memory and data associated with statement and close the connection after generating search results
		pg_free_result($stmt);
		pg_close($conn);

		}
	}
}

else{

	// If server request method is not POST, return error message
	$data['validation'] = false;
	$errors['start'] = 'Insert query could not be started. Please contact the system administrator.';
	$data['errors'] = $errors;
}

// return all data to an AJAX call
echo json_encode($data);

?>