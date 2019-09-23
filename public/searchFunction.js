	$("#searchForm").submit(function(event){
		// Cancels the default form submission
		event.preventDefault();
		getFormDataSearch();
		});


	function getFormDataSearch() {
		
		var getSearchName = document.getElementById("formSearchName").value;
		var getSearchFDate = document.getElementById("formSearchFDate").value;
		var getSearchTDate = document.getElementById("formSearchTDate").value;
		var getOrderBy = document.getElementById("formOrderBy").value;
		var getSort = document.getElementById("formSort").value;

		searchDatabase(getSearchName, getSearchFDate, getSearchTDate, getOrderBy, getSort);
	}


	function searchDatabase(getSearchName, getSearchFDate, getSearchTDate, getOrderBy, getSort) {

		$('.form-group').removeClass('has-error'); // Remove the error class if present
		$('.help-block').remove(); // Remove the error text if present

		var searchRequest = $.ajax({
			type: 'GET',
			url: 'dietsearch_validation.php',
			data: { name: getSearchName,
				fDate: getSearchFDate,
				tDate: getSearchTDate,
				order_by: getOrderBy,
				sort: getSort
				} ,
			dataType: 'json',
			});

			searchRequest.done(function(data) {

				if ( ! data.success) {

					// Error indicator for date format
					if (data.errors.fDate) {
						$('#fDateSearch-group').addClass('has-error');
						$('#fDateSearch-help').append('<span class="help-block">' + data.errors.fDate + '</span>');
					}

					// Error indicator for time format
					if (data.errors.tDate) {
						$('#tDateSearch-group').addClass('has-error');
						$('#tDateSearch-help').append('<span class="help-block">' + data.errors.tDate + '</span>');
					}

					// Error message if search could not be started
					if (data.errors.start)  {
						alert('Form submitted. ' + data.errors.start);
					}

				}

				else {
					window.location = 'dietsearch.php?Name=' + getSearchName + '&fDate=' + getSearchFDate + '&tDate=' + getSearchTDate + '&order_by=' + getOrderBy + '&sort=' + getSort;
				}
			});

			searchRequest.fail(function(data) {

					alert('An unexpected error occurred. Your search request could not be processed. Contact the system administrator if this problem persists.');						

			});

	}