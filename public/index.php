<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Diet Tracker Database</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
	integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
</head>
<body class="bg-info">
	<div class="container-fluid">
		<h1 class="text-center">Diet Tracker</h1>
	</div>
	<div class="container-fluid">
		<br>
		<form id="searchForm" method="get">
			<div class="row">	
				<div id="nameSearch-group" class="col-sm-offset-2 col-sm-3">
					<label class="control-label" for="formSearchName">Food name</label>		
					<input aria-label="Input food name" type="text" class="form-control" id="formSearchName" name="Name">
					<div id="nameSearch-help"></div>
				</div>
				<div id="fDateSearch-group" class="col-sm-2">
					<label class="control-label" for="formSearchFDate">From date</label>
					<div class="input-group date datepicker">
						<input aria-label="Input search from date" type="text" class="form-control" id="formSearchFDate" placeholder="yyyy-mm-dd" name="fDate">
						<span class="input-group-addon">
							<span class="sr-only">Calendar picker</span>
							<i class="glyphicon glyphicon-calendar"></i>
						</span>
					</div>
					<div id="fDateSearch-help"></div>
				</div>
				<div id="tDateSearch-group" class="col-sm-2">
					<label class="control-label" for="formSearchTDate">To date</label>
					<div class="input-group date datepicker">
						<input aria-label="Input search to date" type="text" class="form-control" id="formSearchTDate" placeholder="yyyy-mm-dd" name="tDate">
						<span class="input-group-addon">
							<span class="sr-only">Calendar picker</span>
							<i class="glyphicon glyphicon-calendar"></i>
						</span>
					</div>
					<div id="tDateSearch-help"></div>
				</div>
				<div class="col-sm-3">
					<label class="invisible-label">&nbsp;</label>
					<br>
					<input type="hidden" id="formOrderBy" name="order_by" value="Date">
					<input type="hidden" id="formSort" name="sort" value="desc">		
					<button aria-label="Search button" type="submit" id="formSearchSubmit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>
				</div>
			</div>
		</form>
	</div>
	<br>
	<div class="container-fluid">
		<h3 class="text-center">Diet Record Creation</h3>
		<h5 class="text-center">Input and submit information below to create a new diet record.</h5>
	</div>
	<div class="container-fluid">
		<form id="insertForm" class="form-horizontal" method="post">
			<div class="row">
				<div class="col-sm-12 text-center">
					<button aria-label="Insert record button" type="button" id="insertRecord" onClick="getFormDataInsert()" class="btn btnInsert btn-success btn-md"><span class="glyphicon glyphicon-upload"></span> Insert Record</button>
					<button aria-label="Clear form button" type="reset" class="reset btn btn-danger btn-md" name="reset"><span class="glyphicon glyphicon-erase"></span> Clear Form</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-offset-1 col-sm-5">
					<h4>Food Record Information</h4>
					<div id="foodintake-group" class="form-group">
						<label class="control-label col-sm-4" for="formIntakeID">Food Intake:</label>
						<div class="col-sm-4">
							<select aria-label="Click to open and pick food intake group choices" aria-haspopup="true" aria-expanded="false" class="form-control" data-width="fit" id="formIntakeID">
								<option value="1">Breakfast</option>
								<option value="2">Lunch</option>
								<option value="3">Dinner</option>
								<option value="4">Snacks</option>
								<option value="5">Party Meal</option>
								<option value="6">Meal</option>
								<option value="7">Other</option>
							</select>
						</div>
						<div class="col-sm-4"></div>
					</div> 
					<div id="name-group" class="form-group">
						<label class="control-label col-sm-4" for="formName">Food Name:</label>
						<div class="col-sm-4">
							<input aria-label="Input food name" type="text" class="form-control" name="Name" id="formName" required>
						</div>
						<div id="name-help" class="col-sm-4"></div>
					</div>
					<div id="date-group" class="form-group">
						<label class="control-label col-sm-4" for="formDate">Creation Date:</label>
						<div class="col-sm-4">
							<div class="input-group date datepicker">
								<input aria-label="Input record creation date" type="text" class="form-control datepicker" name="Date" placeholder="yyyy-mm-dd" id="formDate">
								<span class="input-group-addon">
									<span class="sr-only">Calendar picker</span>
									<i class="glyphicon glyphicon-calendar"></i>
								</span>
							</div>
						</div>
						<div id="date-help" class="col-sm-4"></div>
					</div>
					<div id="time-group" class="form-group">
						<label class="control-label col-sm-4" for="formTime">Creation Time:</label>
						<div class="col-sm-4">
							<div class="input-group bootstrap-timepicker timepicker">
								<input aria-label="Input record creation time" type="text" class="form-control" name="Time" placeholder="h:m:s (24 hr)" id="formTime">
								<span class="input-group-addon" id="timepickerCurrent">
									<span class="sr-only">Time picker</span>
									<i class="glyphicon glyphicon-time"></i>
								</span>
							</div>
						</div>
						<div id="time-help" class="col-sm-4"></div>
					</div>
				</div>
				<div class="col-sm-5">
					<h4>Food Nutrition Information</h4>
					<div id="weight_kg-group" class="form-group">
						<label class="control-label col-sm-3" for="formWeight_kg">Weight (kg):</label>
						<div class="col-sm-3">
							<input aria-label="Input weight (kg)" type="text" class="form-control" name="Weight_kg" id="formWeight_kg">
						</div>
						<div id="weight_kg-help" class="col-sm-6"></div>
					</div>
					<div id="calories-group" class="form-group">
						<label class="control-label col-sm-3" for="formCalories">Calories:</label>
						<div class="col-sm-3">
							<input aria-label="Input calories" type="text" class="form-control" name="Calories" id="formCalories">
						</div>
						<div id="calories-help" class="col-sm-6"></div>
					</div>
					<div id="fat_g-group" class="form-group">
						<label class="control-label col-sm-3" for="formFat_g">Fat (g):</label>
						<div class="col-sm-3">
							<input aria-label="Input fat (g)" type="text" class="form-control" name="Fat_g" id="formFat_g">
						</div>
						<div id="fat_g-help" class="col-sm-6"></div>
					</div>
					<div id="carbs-group" class="form-group">
						<label class="control-label col-sm-3" for="formCarbs">Carbs (g):</label>
						<div class="col-sm-3">
							<input aria-label="Input carbs" type="text" class="form-control" name="Carbs" id="formCarbs">
						</div>
						<div id="carbs-help" class="col-sm-6">
						</div>
					</div>
					<div id="proteins_g-group" class="form-group">
						<label class="control-label col-sm-3" for="formProteins_g">Proteins (g):</label>
						<div class="col-sm-3">
							<input aria-label="Input proteins (g)" type="text" class="form-control" name="Proteins_g" id="formProteins_g">
						</div>
						<div id="proteins_g-help" class="col-sm-6"></div>
					</div>
					<div id="comments-group" class="form-group">
						<label class="control-label col-sm-3" for="formComments">Comments:</label>
						<div class="col-sm-6">
							<input aria-label="Input comments" type="text" class="form-control" name="Comments" id="formComments">
						</div>
						<div class="col-sm-3"></div>
					</div>
				</div>
				<div class="col-sm-1"></div>
			</div>
		</form>
	</div>
	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
	integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
	<script src="searchFunction.js"></script>
	<script src="insertFunction.js"></script>
	<script src="settingsDateTimePickers.js"></script>
	</body>
</html>