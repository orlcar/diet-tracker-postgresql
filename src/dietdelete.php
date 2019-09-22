<?php


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	// Validate ID number
	if (!preg_match('/^(?:[1-9]\d*|0)?$/',$_POST['id'])) {
		$data['message'] = 'Error: Invalid ID number. Delete request cancelled.';
		}
	else {

		// Import PostgreSQL connection variables
		include ("config.php");

		// Connect to PostgreSQL server
		$conn = pg_connect("host=$host user=$username password=$password dbname=$dbname");

		// Check connection
		if(!$conn){

			die();

		} else {

			// Parameter preparation
			$id = (int) $_POST['id'];

			// Prepare delete query and statement
			$sql = "DELETE FROM FoodIntake WHERE ID=$1";

			if($stmt = pg_prepare($conn, "delete_query", $sql)){

				// Execute the prepared statement. Will return AJAX failure message if statement execution fails
				$stmt = pg_execute($conn, "delete_query", array($id));

				// Check if delete query successfully delete record
				if(pg_affected_rows($stmt) === 1)  {

					// Successful delete message
					$data['message'] = 'Successful delete!';

				} else if(pg_affected_rows($stmt) === 0)  {

					// No record was deleted
					$data['message'] = 'Error: Record was not deleted. Please check ID value.';

				} else{

					// Generic error message
					$data['message'] = 'Unexpected error.';

				}

			} else{

				// Query format error
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
	$data['message'] = 'Query could not be started. Please contact the system administrator.';
}

// Return all data to an AJAX call
echo json_encode($data);

?>