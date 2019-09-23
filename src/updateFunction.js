	function getFormDataUpdate() {

		var getID = document.getElementById("formID").value;
		var getName = document.getElementById("formName").value;
		var getIntakeID = document.getElementById("formIntakeID").value;
		var getDate = document.getElementById("formDate").value;
		var getTime = document.getElementById("formTime").value;
		var getWeight = document.getElementById("formWeight_kg").value;
		var getCalories = document.getElementById("formCalories").value;
		var getFat = document.getElementById("formFat_g").value;
		var getCarbs = document.getElementById("formCarbs").value;
		var getProteins = document.getElementById("formProteins_g").value;
		var getComments = document.getElementById("formComments").value;

		updateRecord(getID, getName, getIntakeID, getDate, getTime, getWeight, getCalories, getFat, getCarbs, getProteins, getComments);
	}


	function isNormalInteger(str) {
		return /^\+?[1-9]\d*$/.test(str);
		}


	function updateRecord(getID, getName, getIntakeID, getDate, getTime, getWeight, getCalories, getFat, getCarbs, getProteins, getComments) {

		var updateid = getID;

		// Validate ID value
		if (!isNormalInteger(updateid)) {
			alert('No valid ID number. Please choose a record from the search results to edit.');
		}

		// Update record that has valid ID number
		else {
			if(confirm("Do you want to update this record?")){

				$('.form-group').removeClass('has-error'); // Remove the error class if present
				$('.help-block').remove(); // Remove the error text if present

				var updateRequest = $.ajax({
					type: 'POST',
					url: 'dietupdate.php',
					data: { id: updateid,
						name: getName,
						intakeid: getIntakeID,
						date: getDate,
						time: getTime,
						weight_kg: getWeight,
						calories: getCalories,
						fat_g: getFat,
						carbs: getCarbs,
						proteins_g: getProteins,
						comments: getComments
						} ,
					dataType: 'json',
					});

					updateRequest.done(function(data) {

						if ( ! data.validation) {

							// Error indicator for invalid ID
							if (data.errors.id) {
								alert(data.errors.id);
							}

							// Error indicator for name input
							if (data.errors.name) {
								$('#name-group').addClass('has-error');
								$('#name-help').append('<div class="help-block">' + data.errors.name + '</div>');
							}

							// Error indicator for date format
							if (data.errors.date) {
								$('#date-group').addClass('has-error');
								$('#date-help').append('<div class="help-block">' + data.errors.date + '</div>');
							}

							// Error indicator for time format
							if (data.errors.time) {
								$('#time-group').addClass('has-error');
								$('#time-help').append('<div class="help-block">' + data.errors.time + '</div>');
							}

							// Error indicator for weight_kg
							if (data.errors.weight_kg) {
								$('#weight_kg-group').addClass('has-error');
								$('#weight_kg-help').append('<div class="help-block">' + data.errors.weight_kg + '</div>');
							}

							// Error indicator for calories
							if (data.errors.calories) {
								$('#calories-group').addClass('has-error');
								$('#calories-help').append('<div class="help-block">' + data.errors.calories + '</div>');
							}

							// Error indicator for fat_g
							if (data.errors.fat_g) {
								$('#fat_g-group').addClass('has-error');
								$('#fat_g-help').append('<div class="help-block">' + data.errors.fat_g + '</div>');
							}

							// Error indicator for carbs
							if (data.errors.carbs) {
								$('#carbs-group').addClass('has-error');
								$('#carbs-help').append('<div class="help-block">' + data.errors.carbs + '</div>');
							}

							// Error indicator for proteins_g
							if (data.errors.proteins_g) {
								$('#proteins_g-group').addClass('has-error');
								$('#proteins_g-help').append('<div class="help-block">' + data.errors.proteins_g + '</div>');
							}

							// Error message if update query could not be stared
							if (data.errors.start)  {
								alert('Form submitted. ' + data.errors.start);
							}
						} 

						else {
							alert('Form submitted. ' + data.message);
						}
					});

					updateRequest.fail(function(data) {

							alert('There was an error processing the update request. The form could not be submitted. Contact the system administrator if this problem persists.');

					});

			}
		}
	}