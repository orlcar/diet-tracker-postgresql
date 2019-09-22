<?php
		include("diet_conn.php");

		// Food name and date range to search
		if ($_SERVER["REQUEST_METHOD"] == "GET") {

			$searchName = test_input($_GET['Name']);
			$fDate = test_input($_GET['fDate']);
			$tDate = test_input($_GET['tDate']);
			$order_by = test_input($_GET{'order_by'});
			$sort = test_input($_GET{'sort'});

		}

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$url_keys = "Name=".$searchName."&fDate=".$fDate."&tDate=".$tDate."&order_by=".$order_by."&sort=".$sort;

		// Create sort search results link
		function sortorder($fieldname, $name, $fDate, $tDate, $pagenum){
		
			$sorturl = "?pn=".$pagenum."&Name=".$name."&fDate=".$fDate."&tDate=".$tDate."&order_by=".$fieldname."&sort=";
			$sorttype = "asc";
			if(isset($_GET['order_by']) && $_GET['order_by'] == $fieldname){
				if(isset($_GET['sort']) && $_GET['sort'] == "asc"){
					$sorttype = "desc";
				}
				else if(isset($_GET['sort']) && $_GET['sort'] == "desc"){
					$sorttype = "asc";
				}
			}
			$sorturl .= $sorttype;
			return $sorturl;
		}

		// Replace empty values with NULL values for PostgreSQL compatability
		if ($fDate == "") {
			$fDate = NULL;
		}
		if ($tDate == "") {
			$tDate = NULL;
		}

		// Total rows query
		$countSQL = "select count(f.ID) from FoodIntake as f
		INNER JOIN FoodIntake_Type as t on t.IntakeID = f.IntakeID 
		WHERE (f.Name = $1 OR $1 = '')
		AND (f.Date >= $2 OR $2 IS NULL)
		AND (f.Date <= $3 OR $3 IS NULL)";

		if($stmt = pg_prepare($conn, "count_query", $countSQL)){

			// Attempt to execute the prepared statement
			if(!$stmt = pg_execute($conn, "count_query", array($searchName, $fDate, $tDate) )){	
				
				// Binding error for count query
				echo '<div class="container-fluid bg-info">';
					echo '<h3 class="text-center alert-danger">Server Error</h3>';
					echo '<br>';
					echo '<h5>There was an error processing your request. Please contact the website adminstrator.</h5>';
					echo '<h5>Click on the following link to go back to the diet tracker main webpage.</h5>';
					echo '<br>';
					echo '<h4><a href="http://localhost:8000/index.php">Diet Tracker Main Webpage</a></h4>';
					echo '<br>';
				echo '</div>';
				die();

			}

		}
		else{
			// Query preparation error
			echo '<div class="container-fluid bg-info">';
				echo '<h3 class="text-center alert-danger">Server Error</h3>';
				echo '<br>';
				echo '<h5>There was an error processing your request. Please contact the website adminstrator.</h5>';
				echo '<h5>Click on the following link to go back to the diet tracker main webpage.</h5>';
				echo '<br>';
				echo '<h4><a href="http://localhost:8000/index.php">Diet Tracker Main Webpage</a></h4>';
				echo '<br>';
			echo '</div>';
			die();

		}

		// Fetch total rows number from count query
		$total_rows = pg_fetch_result($stmt, 0, 0);

		// Set up page number variables
		$page_rows = 10;

		$last = ceil($total_rows/$page_rows);

		if($last < 1){
			$last = 1;
		}

		$pagenum = 1;

		if(isset($_GET['pn'])){
			$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
		}

		if ($pagenum < 1) { 
			$pagenum = 1; 
		} 
		else if ($pagenum > $last) { 
			$pagenum = $last; 
		}

		// Set up limit variable
    	$limit = 'LIMIT ' .$page_rows;

		// Set up offset variable
		if ($pagenum == 1) {
			$offset = '';
		}
		else {
			$offset = 'OFFSET ' .($pagenum - 1) * $page_rows;
		}

		// Free the memory and data associated with statement for pagination query
		pg_free_result($stmt);

		// Search query using prepared statements
		$searchSQL = "select f.ID, f.Name, f.IntakeID, f.Date, f.Time, f.Weight_kg, f.Calories, 
		f.Fat_g, f.Carbs, f.Proteins_g, f.Comments, t.Description from Foodintake as f
		INNER JOIN FoodIntake_Type as t on t.IntakeID = f.IntakeID 
		WHERE (f.Name = $1 OR $1 = '')
		AND (f.Date >= $2 OR $2 IS NULL)
		AND (f.Date <= $3 OR $3 IS NULL)
		ORDER BY ".$order_by." ".$sort." ".$offset." ".$limit;


		if($stmt = pg_prepare($conn, "search_query", $searchSQL)){

			// Attempt to execute the prepared statement
			if(!$stmt = pg_execute($conn, "search_query", array($searchName, $fDate, $tDate)) ){
				
				// Binding error for count query
				echo '<div class="container-fluid bg-info">';
					echo '<h3 class="text-center alert-danger">Server Error</h3>';
					echo '<br>';
					echo '<h5>There was an error processing your request. Please contact the website adminstrator.</h5>';
					echo '<h5>Click on the following link to go back to the diet tracker main webpage.</h5>';
					echo '<br>';
					echo '<h4><a href="http://localhost:8000/index.php">Diet Tracker Main Webpage</a></h4>';
					echo '<br>';
				echo '</div>';
				die();

			}

		}
		else{
			
			// Query preparation error
			echo '<div class="container-fluid bg-info">';
				echo '<h3 class="text-center alert-danger">Server Error</h3>';
				echo '<br>';
				echo '<h5>There was an error processing your request. Please contact the website adminstrator.</h5>';
				echo '<h5>Click on the following link to go back to the diet tracker main webpage.</h5>';
				echo '<br>';
				echo '<h4><a href="http://localhost:8000/index.php">Diet Tracker Main Webpage</a></h4>';
				echo '<br>';
			echo '</div>';
			die();

		}

		// Pagination control buttons
		$paginationControls = '';
		
		if($last != 1){

			if ($pagenum > 1) {
				$previous = $pagenum - 1;
				$paginationControls .= '<li><a href="'.htmlentities($_SERVER['PHP_SELF']).'?pn='.$previous.'&'.$url_keys.'">Previous</a></li>';

				for($i = $pagenum-4; $i < $pagenum; $i++){
					if($i > 0){
						$paginationControls .= '<li><a href="'.htmlentities($_SERVER['PHP_SELF']).'?pn='.$i.'&'.$url_keys.'">'.$i.'</a></li>';
						}
					}
			}

			$paginationControls .= '<li class="active"><a href="#">'.$pagenum.'<span class="sr-only">(current page)</span></a></li>';

			for($i = $pagenum+1; $i <= $last; $i++){
				$paginationControls .= '<li><a href="'.htmlentities($_SERVER['PHP_SELF']).'?pn='.$i.'&'.$url_keys.'">'.$i.'</a></li>';
				if($i >= $pagenum+4){
					break;
				}
			}

			if ($pagenum != $last) {
				$next = $pagenum + 1;
				$paginationControls .= '<li><a href="'.htmlentities($_SERVER['PHP_SELF']).'?pn='.$next.'&'.$url_keys.'">Next</a></li>';
			}

		}

?>