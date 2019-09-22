		// Datepicker settings
		$(document).ready(function(){
			var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd',
				container: container,
				todayHighlight: true,
				autoclose: true,
				showOnFocus: false
			});
		});

		// Timepicker settings
		$(document).ready(function(){
				$('#formTime').timepicker({
					minuteStep: 1,
					secondStep: 1,
					showSeconds: true,
					showMeridian: false,
					disableFocus: true,
					showInputs: false,
					defaultTime: false
				});
		});

		// Insert current time into creation time input box when timepicker is clicked
		function getTime() {
			var d = new Date();
			var t = (d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds());
			return t;
		}

		$(function () { 
			$('#timepickerCurrent.input-group-addon').mousedown(function(){
				$('#formTime').val(getTime());
			});
		});