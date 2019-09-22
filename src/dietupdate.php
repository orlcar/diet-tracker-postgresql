<?php

$errors = array();		// Array to hold validation errors
$data	= array();		// Array to pass back data

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

// Validation check -- add an error to $errors array if validation check fails

	// Validate filled ID field
	if (empty($_POST['id'])){
		$errors['id'] = 'Error: ID number is required.';
		}

	// Validate ID number
	if (!preg_match('/^(?:[1-9]\d*|0)?$/',$_POST['id'])) {
		$errors['id'] = 'Error: Invalid ID number.';
		}	

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

		}
		else {
			
			// Parameter preparation
			$id = (int) $_POST['id'];

			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

			$intakeid = $_POST['intakeid'];

			$date = $_POST['date'];

			$time = $_POST['time'];

			$weight_kg = $_POST['weight_kg'];

			$calories = $_POST['calories'];

			$fat_g = $_POST['fat_g'];

			$carbs = $_POST['carbs'];

			$proteins_g = $_POST['proteins_g'];

			$comments = filter_var($_POST['comments'], FILTER_SANITIZE_STRING);

			// Prepare update query and statement
			$sql = "UPDATE FoodIntake SET Name=$1, IntakeID=$2, Date=$3, Time=$4, Weight_kg=$5, Calories=$6, Fat_g=$7, Carbs=$8, Proteins_g=$9, Comments=$10
			WHERE ID=$11";

			if($stmt = pg_prepare($conn, "update_query", $sql)){

				// Execute the prepared statement. Will return AJAX failure message if statement execution fails
				if($stmt = pg_execute($conn, "update_query", 
				array($name, $intakeid, $date, $time, $weight_kg, $calories, $fat_g, $carbs, $proteins_g, $comments, $id))){

					// Check if update query successfully update record
					if(pg_affected_rows($stmt) === 1)  {

						// Success message
						$data['validation'] = true;
						$data['message'] = 'Successful update!';

					} else if(pg_affected_rows($stmt) === 0)  {

						// No record was updated
						$data['validation'] = true;
						$data['message'] = 'Error: Record was not updated.';

					} else{

						// Generic error message
						$data['validation'] = true;
						$data['message'] = 'Unexpected error.';

					}

				} else{

					// Invalid form entries error message
					$data['validation'] = true;
					$data['message'] = 'There was an error in the form. Record was not updated. Please check your form values.';
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
	$errors['start'] = 'Query could not be started. Please contact the system administrator.';
	$data['errors'] = $errors;

}

// Return all data to an AJAX call
echo json_encode($data); 

?>