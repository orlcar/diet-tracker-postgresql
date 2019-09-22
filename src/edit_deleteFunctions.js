	// Edit record function
	$(document).ready(function(){

		$("#dietTable").on('click', '.btnSelect', function() {

		var currentRow = $(this).closest("tr"); // Get the current row

		var col1 = currentRow.find(".dietID").text(); // Get current row 1st table cell TD value
		var col2 = currentRow.find(".dietName").text(); // Get current row 2nd table cell TD value
		var col3 = currentRow.find(".dietIntakeID").text(); // Get current row 3rd table cell TD value
		var col4 = currentRow.find(".dietDate").text(); // Get current row 4th table cell TD value
		var col5 = currentRow.find(".dietTime").text(); // Get current row 5th table cell TD value
		var col6 = currentRow.find(".dietWeight").text(); // Get current row 6th table cell TD value
		var col7 = currentRow.find(".dietCalories").text(); // Get current row 7th table cell TD value
		var col8 = currentRow.find(".dietFat").text(); // Get current row 8th table cell TD value
		var col9 = currentRow.find(".dietCarbs").text(); // Get current row 9th table cell TD value
		var col10 = currentRow.find(".dietProteins").text(); // Get current row 10th table cell TD value
		var col11 = currentRow.find(".dietComments").text(); // Get current row 11th table cell TD value
		var col12 = currentRow.find(".dietDescription").text(); // Get current row 12th table cell TD value
		
		// Combine column data and make alert confirmation window
		var data = 'ID:  ' + col1 + "\nName:  " + col2 + "\nIntakeID:  " + col3 + "\nDate:  " + col4 + "\nTime:  " + col5 + "\nWeight (kg):  " + col6
		+ "\nCalories:  " + col7 + "\nFat (g):  " + col8 + "\nCarbs (g):  " + col9 + "\nProteins (g):  " + col10 + "\nComments:  " + col11 + "\nDescription:  " + col12;

		alert('Chosen record to edit:\n\n' + data);

		// Insert column data into form
		document.getElementById("formID").value=col1;
		document.getElementById("formName").value=col2;
		document.getElementById("formIntakeID").value=col3;
		document.getElementById("formDate").value=col4;
		document.getElementById("formTime").value=col5;
		document.getElementById("formWeight_kg").value=col6;
		document.getElementById("formCalories").value=col7;
		document.getElementById("formFat_g").value=col8;
		document.getElementById("formCarbs").value=col9;
		document.getElementById("formProteins_g").value=col10;
		document.getElementById("formComments").value=col11;

		});
	});

	// Delete record function
	function deleteRecord(delID) {

		var deleteID = delID;

		if(confirm("Do you want to delete this record?")){

			var deleteRequest = $.ajax({
				type: 'POST',
				url: 'dietdelete.php',
				data: { id: deleteID } ,
				dataType: 'json',
				});

				deleteRequest.done(function(data) {
					alert(data.message);
					window.location.reload();
				});

				deleteRequest.fail(function(data) {
					alert('There was an error processing the delete request. Contact the system administrator if this problem persists.');
				});
		}
	}