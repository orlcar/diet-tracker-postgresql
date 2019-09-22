<?php

$errors = array();		// Array to hold errors
$data	= array();		// Array to pass back data

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

	// Sanitize the variables
	function test_input($dataInput) {
		$data = trim($dataInput);
		$data = stripslashes($dataInput);
		$data = htmlspecialchars($dataInput);
		return $dataInput;
		}

	$name = test_input($_GET['name']);
	$fDate = test_input($_GET['fDate']);
	$tDate = test_input($_GET['tDate']);
	$order_by = test_input($_GET{'order_by'});
	$sort = test_input($_GET{'sort'});

// Validation check -- add an error to $errors array if validation check fails

	// Validate fDate and allow empty field
	if (!preg_match('/^((19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01]))?$/',$fDate)) {
		$errors['fDate'] = 'Invalid date.';
		}

	// Validate tDate and allow empty field
	if (!preg_match('/^((19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01]))?$/',$tDate)) {
		$errors['tDate'] = 'Invalid date.';
		}

// Return a response

	// If errors array contains errors, return error messages
	if ( ! empty($errors)) {

		$data['success'] = false;
		$data['errors']  = $errors;
	}

	else {
		$data['success'] = true;
	}

}
else{ 

	// If server request method is not GET, return error message
	$data['success'] = false;
	$errors['start'] = 'Search query could not be started. Please contact the system administrator.';
	$data['errors'] = $errors;

}

// Return all data to an AJAX call
echo json_encode($data);

?>