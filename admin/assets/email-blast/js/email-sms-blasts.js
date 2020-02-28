$(document).ready(function () {
	// Datepickers	
	$('#visit_date').datepicker()
		.on('changeDate', function(ev){                 
		$('#visit_date').datepicker('hide');
	});
});

$(document).ready(function () {
	
	// Datepickers
	$('#min').datepicker({
		onSelect: function () {
			table.draw();
		},
		changeMonth: true,
		changeYear: true
	});

	$('#max').datepicker({
		onSelect: function () {
			table.draw();
		},
		changeMonth: true,
		changeYear: true
	});
	
	// Datatable - One ( Master Campaign )
	if ($('#datatable-button-data').length) {
		
		var table = $('#datatable-button-data').DataTable({
			pageLength: 100,
			dom: 'Bfrtip',
			buttons: [{
				extend: 'csvHtml5',
				text: 'Export CSV',
				filename: 'patient-files',
				className: 'btn-sm',
				exportOptions: {
					columns: [1, 2, 3]
				}
			}],
			orderCellsTop: true,
			responsive: !0
		});
		// Clone Previous Row for filter input
		$('#datatable-button-data>thead>tr')
			.clone(true)
			.appendTo('#datatable-button-data thead');
		$('#datatable-button-data>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'Action' && title != 'Status') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});
		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	
	// Datatable - One ( Master Campaign )
	if ($('#datatable-buttons').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			var startDate = new Date(data[6]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});
		var table = $('#datatable-buttons').DataTable({
			pageLength: 100,
			dom: 'Bfrtip',
			buttons: [{
				extend: 'csvHtml5',
				text: 'Export CSV',
				filename: 'patient-files',
				className: 'btn-sm',
				exportOptions: {
					columns: [1, 2, 3]
				}
			}],
			orderCellsTop: true,
			responsive: !0
		});
		// Clone Previous Row for filter input
		$('#datatable-buttons>thead>tr')
			.clone(true)
			.appendTo('#datatable-buttons thead');
		$('#datatable-buttons>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'Action' && title != 'Status') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});
		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	
	// Datatable - One ( Master Campaign )
	if ($('#datatable-buttons-import-data').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});
		var table = $('#datatable-buttons-import-data').DataTable({
			pageLength: 100,
			dom: 'Bfrtip',
			buttons: [{
				extend: 'csvHtml5',
				text: 'Export CSV',
				filename: 'patient-files',
				className: 'btn-sm',
				exportOptions: {
					columns: [1, 2, 3]
				}
			}],
			orderCellsTop: true,
			responsive: !0
		});
		// Clone Previous Row for filter input
		$('#datatable-buttons-import-data>thead>tr')
			.clone(true)
			.appendTo('#datatable-buttons-import-data thead');
		$('#datatable-buttons-import-data>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'Action' && title != 'Status') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});
		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	
	// Datatable - Two ( Campaign )
	if ($('#datatable-campaign-users').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			var startDate = new Date(data[3]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-campaign-users').DataTable({
			"pageLength": 200
		});

		$('#datatable-campaign-users>thead>tr')
			.clone(true)
			.appendTo('#datatable-campaign-users thead');
		$('#datatable-campaign-users>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}

	// Import Filter Data
	$('#filter-data-import').click(function () {
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: 'email_sms_blast/import_filter_data',
					data: {
						user_id: values
					},
					success: function (data) {
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-data-import').disabled = true;
							window.location.href = 'email_sms_blast/campaign';
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = 'email_sms_blast/campaign';
						}
					}
				});
			} else {
				alert('please upload some users!');
			}
		
	});
	
	// Import Filter Data
	$('#filter-sms-data-import').click(function () {
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: 'email_sms_blast/import_filter_sms_data',
					data: {
						user_id: values
					},
					 beforeSend: function(){
						// Show image container
						$("#loader").show();
					},
					success: function (data) {
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-sms-data-import').disabled = true;
							window.location.href = 'email_sms_blast/campaign';
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = 'email_sms_blast/campaign';
						}
					},
					complete:function(data){
						// Hide image container
						$("#loader").hide();
					}
				});
			} else {
				alert('please upload some users!');
			}
		
	});
	
	// Import Facebook Filter Data
	$('#filter-fb-data-import').click(function () {
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: 'email_sms_blast/import_filter_fb_data',
					data: {
						user_id: values
					},
					success: function (data) {
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-fb-data-import').disabled = true;
							window.location.href = 'email_sms_blast/campaign';
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = 'email_sms_blast/campaign';
						}
					}
				});
			} else {
				alert('please upload some users!');
			}
		
	});
	
	// Import Facebook Filter Data
	$('#filter-fb-email-data-import').click(function () {
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: 'email_sms_blast/import_filter_fb_email_data',
					data: {
						user_id: values
					},
					success: function (data) {
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-fb-email-data-import').disabled = true;
							window.location.href = 'email_sms_blast/campaign';
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = 'email_sms_blast/campaign';
						}
					}
				});
			} else {
				alert('please upload some users!');
			}
		
	});
	
	// Import Txgidocs Email Filter Data
	$('#filter-dldc-email-data-import').click(function () {
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: 'email_sms_blast/import_filter_dldc_email_data',
					data: {
						user_id: values
					},
					success: function (data) {
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-dldc-email-data-import').disabled = true;
							window.location.href = 'email_sms_blast/campaign';
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = 'email_sms_blast/campaign';
						}
					}
				});
			} else {
				alert('please upload some users!');
			}
		
	});
	
	// Import Txgidocs SMS Filter Data
	$('#filter-dldc-sms-data-import').click(function () {
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: 'email_sms_blast/import_filter_dldc_sms_data',
					data: {
						user_id: values
					},
					success: function (data) {
						
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-dldc-sms-data-import').disabled = true;
							window.location.href = 'email_sms_blast/campaign_data';
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = 'email_sms_blast/campaign_data';
						}
					}
				});
			} else {
				alert('please upload some users!');
			}		
	});
	
	// Import Email SMS Filter Data
	$('#send-email-sms-filter-data-import').click(function () {
		document.getElementById('send-email-sms-filter-data-import').disabled = true;
		var base_url = $('#base-url').val();
		var campaign_category_id = $('#campaign_category_id').val();
		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
			
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: base_url + 'email_sms_blast/import_send_email_sms_filter_data',
					data: {
						user_id : values,
						campaign_category_id: campaign_category_id
					},
					beforeSend: function() {
					  $("#loading-image").show();
				   }, 				 
					success: function (data) {						
						if(data == '1') {
							$("#myDiv").hide();
							alert('Successfully sent mail.');
							document.getElementById('send-email-sms-filter-data-import').disabled = true;
							window.location.href = base_url+'email_sms_blast/campaign_data';
						}else if(data == '0') {
							$("#myDiv").hide();
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = base_url+'email_sms_blast/campaign_data';
						}else{
							$("#myDiv").hide();
							alert('Successfully sent mail.');
							document.getElementById('send-email-sms-filter-data-import').disabled = true;
							window.location.href = base_url+'email_sms_blast/campaign_data';
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						$("#myDiv").hide();
						alert('Successfully sent mail.');
						location.reload();
					}
				});
			} else {
				alert('please upload some users!');
			}
		
	});
	
	// Send Date Datepicker
	$('#send-date').datepicker();

	// Smart Wizard
	var baseUrl = $('#base-url').val();
	$('#wizard').smartWizard({
		autoAdjustHeight: true, // Automatically adjust content height
		onFinish: onFinishCallback,
		hideButtonsOnDisabled: true
	});

	function onFinishCallback() {
		var baseUrl = $('#base-url').val();
		var campaign_category_id = $('#campaign_category_id').val();
		var campaignId = $('#campaign-id').val();
		var campaignName = $('#campaign-name').val();
		var campaignDesc = CKEDITOR.instances['text'].getData();
		var campaignType = $('#campaign-type').val();
		var sendDate = $('#send-date').val();
		var emailTemplate = $('#email-template').val();
		var smsTemplate = $('#sms-template').val();

		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
		if (campaignName.length > 0 && emailTemplate.length > 0) {
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: baseUrl + 'email_sms_blast/insert_campaign_data',
					data: {
						campaign_category_id: campaign_category_id,
						campaign_id: campaignId,
						campaign_name: campaignName,
						campaign_desc: campaignDesc,
						campaign_type: campaignType,
						send_date: sendDate,
						user_id: values,
						email_template: emailTemplate
					},
					success: function (data) {
						window.location.href = baseUrl + 'email_sms_blast/campaign';
					}
				});
			}
		} else if (campaignName.length > 0 && smsTemplate.length > 0) {
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: baseUrl + 'email_sms_blast/insert_campaign_data',
					data: {
						campaign_category_id: campaign_category_id,
						campaign_id: campaignId,
						campaign_name: campaignName,
						campaign_desc: campaignDesc,
						campaign_type: campaignType,
						send_date: sendDate,
						user_id: values,
						email_template: smsTemplate
					},
					success: function (data) {
						window.location.href = baseUrl + 'email_sms_blast/campaign';
					}
				});
			}
		} else {
			alert('Something Went Wrong!. Please try again!.');
			window.location.href = baseUrl + 'email_sms_blast/add_edit_campaign';
		}
	}

	// Add classes to buttons
	$('.buttonNext').addClass('btn btn-success'),
		$('.buttonPrevious').addClass('btn btn-primary'),
		$('.buttonFinish')
		.addClass('btn btn-default')
		.text('Save');
	
	// Email Tracking Datatable Report
	if ($('#datatable-email').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-email').DataTable({
			"pageLength": 200
		});

		$('#datatable-email>thead>tr')
			.clone(true);
			//.appendTo('#datatable-email thead');
		$('#datatable-email>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}

	// SMS Tracking Datatable Report
	if ($('#datatable-sms').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-sms').DataTable({
			"pageLength": 200
		});

		$('#datatable-sms>thead>tr')
			.clone(true);
			//.appendTo('#datatable-email thead');
		$('#datatable-sms>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	
	// FB Email Tracking Datatable Report
	if ($('#datatable-fb-email').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-fb-email').DataTable({
			"pageLength": 200
		});

		$('#datatable-fb-email>thead>tr')
			.clone(true);
			//.appendTo('#datatable-email thead');
		$('#datatable-fb-email>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	// FB SMS Tracking Datatable Report
	if ($('#datatable-fb-sms').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-fb-sms').DataTable({
			"pageLength": 200
		});

		$('#datatable-fb-sms>thead>tr')
			.clone(true);
			//.appendTo('#datatable-email thead');
		$('#datatable-fb-sms>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	// DLDC Email Tracking Datatable Report
	if ($('#datatable-dldc-email').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-dldc-email').DataTable({
			"pageLength": 200
		});

		$('#datatable-dldc-email>thead>tr')
			.clone(true);
			//.appendTo('#datatable-email thead');
		$('#datatable-dldc-email>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
	
	// DLDC SMS Tracking Datatable Report
	if ($('#datatable-dldc-sms').length) {
		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
			
			var startDate = new Date(data[4]);
			if (min == null && max == null) {
				return true;
			}
			if (min == null && startDate <= max) {
				return true;
			}
			if (max == null && startDate >= min) {
				return true;
			}
			if (startDate <= max && startDate >= min) {
				return true;
			}
			return false;
		});

		var table = $('#datatable-dldc-sms').DataTable({
			"pageLength": 200
		});

		$('#datatable-dldc-sms>thead>tr')
			.clone(true);
			//.appendTo('#datatable-email thead');
		$('#datatable-dldc-sms>thead>tr:eq(1)>th').each(function (i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function () {
					if (table.column(i).search() !== this.value) {
						table
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}
});

// Graphical Reports
if ($('#mybarChart').length) {
	var f = document.getElementById('mybarChart').getContext("2d");
	var p = document.getElementById('piechart').getContext("2d");
	var opened = document.getElementById('mail-opened').value;
	var notOpened = document.getElementById('mail-unopened').value;
	var commentsPosted = document.getElementById('mail-comments-posted').value;
	var commentsNotPosted = document.getElementById('mail-comments-not-posted').value;
	var txgidocsReviews = document.getElementById('mail-txgidocs').value;
	var googleReviews = document.getElementById('mail-google').value;
	var facebookReviews = document.getElementById('mail-facebook').value;
	var mailSent = document.getElementById('mail-sent').value;

	/* function campaign(e) {
		var baseUrl = $('#base_url').val();
		var campaign_type = $('#campaign_type').val();
		$.ajax({
			method: 'POST',
			url: baseUrl + 'email_sms_blast/graphical_campaign_id',
			data: {
				provider_name: e,
				campaign_type: campaign_type
			},
			cache: false,
			success: function (data) {
				var campaignData = JSON.parse(data);
				var chartData = [];
				var chartsData = [];
				if (campaignData.type == 'email') {
					$('#barchart').show();
					$('#title').show();
					$('#title-report').show();
					var link_not_opened = (campaignData.sent - campaignData.link_open);
					chartData.push(campaignData.sent);
					chartData.push(campaignData.link_open);
					chartData.push(link_not_opened);
					chartsData.push(campaignData.link_open);
					// chartsData.push(campaignData.posted);
					// chartsData.push(campaignData.not_posted);

					if (window.bar != undefined) {
						window.bar.destroy();
					}
					chart = new Chart(f, {
						type: 'bar',
						data: {
							labels: [
								'Sent',
								'Opened',
								'Unopened'
							],
							datasets: [{
								backgroundColor: [
									'#26B99A',
									'#EE82EE',
									'#DA70D6'
								],
								data: chartData
							}]
						},
						options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: !0,
										stepSize: 100
									}
								}]
							}
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										stepSize: 100
									}
								}]
							}
						}
					});

					if (window.chart != undefined) {
						window.chart.destroy();
					}
					charts = new Chart(p, {
						type: 'bar',
						data: {
							labels: [
								'Opened',
								'Comments Posted'
							],
							datasets: [{
								backgroundColor: [
									'#CC0066',
									'#000099'
								],
								data: chartsData
							}]
						},
						options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: !0,
										stepSize: 100
									}
								}]
							}
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										stepSize: 100
									}
								}]
							}
						}
					});

					window.bar = chart;
					window.chart = charts;

				} else if (campaignData.type == 'sms') {
					$('#barchart').show();
					$('#title').show();
					$('#title-report').show();
					var link_not_opened = (campaignData.sent - campaignData.link_open);
					chartData.push(campaignData.sent);
					chartData.push(campaignData.link_open);
					chartData.push(link_not_opened);
					chartsData.push(campaignData.link_open);
					// chartsData.push(campaignData.posted);
					// chartsData.push(campaignData.not_posted);

					if (window.bar != undefined) {
						window.bar.destroy();
					}

					var chart = new Chart(f, {
						type: 'bar',
						data: {
							labels: [
								'Sent',
								'Opened',
								'Unopened'
							],
							datasets: [{
								backgroundColor: [
									'#26B99A',
									'#EE82EE',
									'#DA70D6'
								],
								data: chartData
							}]
						},
						options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: !0,
										stepSize: 100
									}
								}]
							}
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										stepSize: 100
									}
								}]
							}
						}
					});

					if (window.chart != undefined) {
						window.chart.destroy();
					}
					charts = new Chart(p, {
						type: 'bar',
						data: {
							labels: [
								'Opened',
								'Comments Posted'
							],
							datasets: [{
								backgroundColor: [
									'#CC0066',
									'#000099'
								],
								data: chartsData
							}]
						},
						options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: !0,
										stepSize: 100
									}
								}]
							}
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										stepSize: 100
									}
								}]
							}
						}
					});

					window.bar = chart;
					window.chart = charts;

				} else {
					$('#barchart').show();
					$('#title').show();
					$('#title-report').show();
					var link_not_opened = (campaignData.not_opened - campaignData.sms_link);
					chartData.push(campaignData.sent);
					chartData.push(campaignData.sms_link);
					chartData.push(link_not_opened);
					chartsData.push(campaignData.sms_link);
					chartsData.push(campaignData.posted);
					// chartsData.push(campaignData.not_posted);

					if (window.bar != undefined) {
						window.bar.destroy();
					}

					var chart = new Chart(f, {
						type: 'bar',
						data: {
							labels: [
								'Sent',
								'Opened',
								'Unopened'
							],
							datasets: [{
								backgroundColor: [
									'#26B99A',
									'#EE82EE',
									'#DA70D6'
								],
								data: chartData
							}]
						},
						options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: !0,
										stepSize: 100
									}
								}]
							}
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										stepSize: 100
									}
								}]
							}
						}
					});

					if (window.chart != undefined) {
						window.chart.destroy();
					}
					charts = new Chart(p, {
						type: 'bar',
						data: {
							labels: [
								'Opened',
								'Comments Posted'
							],
							datasets: [{
								backgroundColor: [
									'#CC0066',
									'#000099'
								],
								data: chartsData
							}]
						},
						options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: !0,
										stepSize: 100
									}
								}]
							}
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										stepSize: 100
									}
								}]
							}
						}
					});

					window.bar = chart;
					window.chart = charts;
				}
			}
		});
	} */
	function campaign(e) {
		var baseUrl = $('#base_url').val();
		var campaign_type = $('#campaign_type').val();
		$.ajax({
			method: 'POST',
			url: baseUrl + 'email_sms_blast/graphical_campaign_id',
			data: {
				campaign_id: e
			},
			cache: false,
			success: function (data) {
				if(data != '')
				{
					var campaignData = JSON.parse(data);
					var chartData = [];
					var chartsData = [];
					if (campaignData != '') {
						$('#barchart').show();
						$('#title').show();
						$('#title-report').show();
						var link_not_opened = (campaignData.sent - campaignData.link_open);
						chartData.push(campaignData.sent);
						chartData.push(campaignData.link_open);
						chartData.push(link_not_opened);
						chartsData.push(campaignData.link_open);
						// chartsData.push(campaignData.posted);
						// chartsData.push(campaignData.not_posted);

						if (window.bar != undefined) {
							window.bar.destroy();
						}
						chart = new Chart(f, {
							type: 'bar',
							data: {
								labels: [
									'Sent',
									'Opened',
									'Unopened'
								],
								datasets: [{
									backgroundColor: [
										'#26B99A',
										'#EE82EE',
										'#DA70D6'
									],
									data: chartData
								}]
							},
							options: {
								legend: {
									display: false
								},
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: !0,
											stepSize: 100
										}
									}]
								}
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true,
											stepSize: 100
										}
									}]
								}
							}
						});

						if (window.chart != undefined) {
							window.chart.destroy();
						}
						charts = new Chart(p, {
							type: 'bar',
							data: {
								labels: [
									'Opened',
									'Comments Posted'
								],
								datasets: [{
									backgroundColor: [
										'#CC0066',
										'#000099'
									],
									data: chartsData
								}]
							},
							options: {
								legend: {
									display: false
								},
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: !0,
											stepSize: 100
										}
									}]
								}
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true,
											stepSize: 100
										}
									}]
								}
							}
						});

						window.bar = chart;
						window.chart = charts;
					}
				}else {
					$('#barchart').hide();
					$('#title').hide();
					$('#title-report').hide();					
				}	
			}
		});
	}
}
//onchage function for campaign id
 $(document).ready(function () {
	var option = '<option value="">Select Campaign</option>';
		$('#campaign_name_data').html(option);
		$('#barchart').hide();
});
//Onchange Function For Template
/* function campaign_type(value) {
	var baseUrl = $('#base_url').val();
	if (value == "") {
		var option = '<option value="">Select Provider Name</option>';
		$('#campaign_name_data').html(option);
		$('#barchart').hide();
	}else{
		var option = '<option value="">Select Provider Name</option><option value="dldc">DLDC</option><option value="reddy">REDDY</option><option value="hamat">HAMAT</option><option value="facebook">Facebook</option><option value="txgidocs">Txgidocs</option>';
		$('#campaign_name_data').html(option);
		$('#barchart').hide();
	}	
} */
function campaign_type(value) 
{
	var baseUrl = $('#base_url').val();
	$.ajax({
		method: 'POST',
		url: baseUrl + 'email_sms_blast/get_graphics_data',
		data: {
			value: value
		},
		success: function (data) {
			if (data == "") {
				$('#campaign_name_data').html(data);
				$('#barchart').hide();
				
			} else {
				$('#campaign_name_data').html(data);
				$('#barchart').hide();
			}
		}
	});
}

// Email Template Preview
$('#preview_template').click(function () {
	var campaignId = $('#hidden-selected-id').val();
	var baseUrl = $('#base_url').val();
	var imageUrl = $('#image_url').val();

	if (campaignId.length > 0) {
		$.ajax({
			method: 'POST',
			url: baseUrl + 'email_sms_blast/get_campaign_template',
			data: {
				campaign_id: campaignId
			},
			success: function (data) {
				if (data != 0) {
					var img =
						'<img class="preview-template-img" src="' +
						imageUrl +
						'images/txgidocs/' +
						data +
						'">';
					$('#preview-template-modal').modal('show');
					$('#modal-body-img').html(img);
				} else {
					var img =
						'<img class="preview-template-img" src="' +
						imageUrl +
						'images/noimage.png">';
					$('#preview-template-modal').modal('show');
					$('#modal-body-img').html(img);
				}
			}
		});
	} else {
		alert('Please Select Campaign.');
	}
});

// Email Template Preview
$('#preview_sms_template').click(function () {
	var img = '<img class="preview-template-img" src="http://txgidocs.mailtides.com/assets/images/txgidocs/email-template/google.png">';
	$('#preview-sms-template-modal').modal('show');
	$('#modal-body-img').html(img);
});

$(document).ready(function () {
	$('#campaign_id').on('change', function () {
		var selectedId = $(this).val();
		$('#hidden-selected-id').val(selectedId);
	});

	// Preview Template Campaign

	$('#preview-template-campaign').click(function () {
		var selectedTemplate = $('#template_id option:selected').val();
		var imageUrl = $('#image-url').val();
		if (selectedTemplate.length > 0) {
			if (selectedTemplate == 1) {
				var img =
					'<img class="preview-template-img" src="' +
					imageUrl +
					'images/txgidocs/mail-template/digestive-and-liver-disease-consultants-template.png">';
				$('#preview-template-modal').modal('show');
				$('#modal-body-img').html(img);
			}

			if (selectedTemplate == 2) {
				var img =
					'<img class="preview-template-img" src="' +
					imageUrl +
					'images/txgidocs/mail-template/google-template.png">';
				$('#preview-template-modal').modal('show');
				$('#modal-body-img').html(img);
			}

			if (selectedTemplate == 3) {
				var img =
					'<img class="preview-template-img" src="' +
					imageUrl +
					'images/txgidocs/mail-template/facebook-template.png">';
				$('#preview-template-modal').modal('show');
				$('#modal-body-img').html(img);
			}
		}
	});
});


$(document).ready(function () {
	// Logo Preview
	$(function () {
		$('#image').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, '');
			$('#image').val(res);
			var res1 = res.replace(httpUrl + '/images/', 'thumbs/');
			$('#image_preview')
				.attr('src', image_url + res1)
				.show();
			if (res1.length == 0) {
				$('#image_preview2').attr('src', image_url + 'images/no-logo.png');
			} else {
				$('#image_preview2').attr('src', image_url + res1);
			}
		});
	});
	// Remove logo
	$('#btn_ok').click(function () {
		var id = $('#text-image-id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'email_sms_blast/remove_email_template_image',
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#image').val('');
				$('#show_image1').hide();
				$('#show_image2').show();
				$('#imageRemove').hide();
				$('#confirm-delete').modal('hide');
				$('#image_preview2').attr('src', image_url + 'images/no-logo.png');
				if (data == 1) {
					// new PNotify({
					// 	title: 'Image Deleted',
					// 	text: 'Just to let you know, Logo Deleted Successfully.',
					// 	type: 'info',
					// 	styling: 'bootstrap3'
					// });
				}
			}
		});
	});
});

$('#btn').click(function () {
	$('#loader').addClass('loader');
	window.setTimeout(function () {
		$('#loader')
			.removeClass('loader hidden')
			.addClass('done');
	});
});


$('#campaign-name').blur(function () {
	$('#error').html('');
	var base_url = $('#base-url').val();
	var Name = $(this).val();

	if (Name.length != 0) {
		$.ajax({
			type: 'POST',
			url: base_url + 'email_sms_blast/check_campaign_name',
			data: {
				campaign_name: Name
			},
			success: function (data) {
				if (data == 0) {
					$('#error').html(
						'<p style="color:green;font-size: 14px;font-weight:bold">Campaign Name is Available.</p>'
					);
				} else {
					$('#error').html(
						'<p style="color:red;font-size: 14px; font-weight:bold;"> Campaign Name Already Exists.</p>'
					);
					$('#campaign-name').val('');
					$('#campaign-name').focus();
				}
			}
		});
	}
});

/* $('#campaign_type').blur(function () {
	$('#error').html('');
	var base_url = $('#base-url').val();
	var Name = $(this).val();
	var website_id = $('#website_id').val();
	if (Name.length != 0) {
		$.ajax({
			type: 'POST',
			url: base_url + 'email_sms_blast/check_campaign_type_name',
			data: {
				campaign_name: Name,
				website_id: website_id
			},
			success: function (data) {
				if (data == 0) {
					$('#error').html(
						'<p style="color:green;font-size: 12px;position:absolute;font-weight:bold; top:0">Campaign Name is Available.</p>'
					);
				} else {
					$('#error').html(
						'<p  style="color:red;font-size: 12px;position:absolute;font-weight:bold; top:0"> Campaign Name Already Exists.</p>'
					);
					$('#campaign_type').val('');
					$('#campaign_type').focus();
				}
			}
		});
	}
}); */


// User Reports
if ($('#mybarChart_type').length) {
	var f = document.getElementById('mybarChart_type');
	//var opened = document.getElementById('mail-opened-type').value;

	function campaign_types(m) {
		
		var baseUrl = $('#base_url').val();
		localStorage.clear();
		$.ajax({
			method: 'POST',
			url: baseUrl + 'email_sms_blast/graphical_campaign_type',
			data: {
				campaign_category_id: m
			},
			cache: false,
			success: function (data) {

				var campaignData = JSON.parse(data);

				if (window.bar != undefined) {
					window.bar.destroy();
				}

				var chart = new Chart(f, {
					type: 'bar',
					data: {
						labels: campaignData.campaign_name,

						datasets: [{
							backgroundColor: '#EE82EE',
							data: campaignData.campaign_values
						}]
					},
					options: {
						legend: {
							display: false
						},
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: !0
								}
							}]
						}
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true,
									stepSize: 100
								}
							}]
						}
					}
				});
				window.bar = chart;
			}
		});
	}
}

function changetemplate() {
	var campaign_type = $('#campaign-type').val();
	if (campaign_type == 'email') {
		$('#templates').html(
			'<p>Email Template</p>'
		);
		$('#preview_templates').hide();
		$('#templates_step').show();
	} else if (campaign_type == 'sms') {
		$('#templates').html(
			'<p>Sms Template</p>'
		);
		$('#templates_step').hide();
		$('#preview_templates').show();
	}
}
$(document).ready(function () {
	var campaign_type = $('#campaign-type').val();
	if (campaign_type == 'email') {
		$('#templates').html(
			'<p>Email Template</p>'
		);
		$('#preview_templates').hide();
		$('#templates_step').show();
	} else if (campaign_type == 'sms') {
		$('#templates').html(
			'<p>Sms Template</p>'
		);
		$('#templates_step').hide();
		$('#preview_templates').show();
	} else {
		$('#preview_templates').hide();
		$('#templates_step').hide();
	}
});

$('#phone_number').blur(function () {
	var phone_number = $('#phone_number').val();
	var base_url = $('#base_url').val();
	$.ajax({
		type: 'POST',
		url: base_url + 'email_sms_blast/check_patient_phone_number',
		data: {
			phone_number: phone_number
		},
		success: function (result) {
			var data = JSON.parse(result);
			if (data) {
				if (data.first_name === 'undefined' && data.last_name === 'undefined') {

				} else {
					$('#first_name').val(data.first_name);
					$('#last_name').val(data.last_name);
				}
				if (data.patient_email === 'undefined') {

				} else {
					$('#patient_email').val(data.patient_email);
					$('#hidden_patient_email').val(data.patient_email);
				}
				$('#carrier_data').val(data.sms_address);
				$('#hidden_carrier_data').val(data.sms_address);
				$('#carrier_data').prop("disabled", true);
			}else{
				$('#first_name').val('');
				$('#last_name').val('');
				$('#patient_email').val('');
				$('#carrier_data').val('');
			}
		}
	});
});
/* 
$(document).ready(function () {
	
	var base_url = $('#base_url').val();
	
	var dataTable = $('#table_grid1').DataTable({
		oLanguage: {
			sProcessing: '<div class="load_first loadericon1"><div class="load_second loadericon2"><div class="load_third loadericon3"></div></div></div>'
		},
		"processing": true,
		"serverSide": true,
		"aLengthMenu": [[25, 50, 75, 100], [25, 50, 75, 100]],
		"iDisplayLength": 100,
		"dom": 'lBfrtip',       
		"buttons": [{
		    extend: 'collection',
		    text: 'Export',
		}],      
		"ajax": {
			url: base_url + 'email_sms_blast/test_datatable',
			type: "post",  
			error: function(){  
				$(".employee-grid-error").html("");
				$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#employee-grid_processing").css("display", "none");
			}
		},
		initComplete:function(){ 
			
				var title = $(this).text();
				if (title.length > 0 && title != 'S.No') {
					$(this).html(
						'<input type="text" placeholder="Search ' + title + '" />'
					);
					$('input', this).on('keyup change', function () {
						if (dataTable.column(i).search() !== this.value) {
							dataTable
								.column(i)
								.search(this.value)
								.draw();
						}
					});
				}
			
		} 
	});
}); */
/* 
  // render order list data table
  // default render page
  jQuery(document).ready(function() {
	  alert();
    var data = {name:"", email:"", phone_number:"", provider_name:"", facility_name:"", visited_date:""};
    generateOrderTable(data);
  });

  // render date datewise
  jQuery(document).on('click','#filter_email_filter', function(){
    var name = jQuery('input#filter-name').val();    
    var email = jQuery('input#filter-email').val();
    var phone_number = jQuery('input#filter-phone-number').val();    
    var provider_name = jQuery('input#filter-provider-name').val();
	var facility_name = jQuery('input#filter-facility-name').val();
	var visited_date = jQuery('input#filter-visited-date').val();
    var data = {name:name, email:email, phone_number:phone_number, provider_name:provider_name, facility_name:facility_name, visited_date:visited_date};
    generateOrderTable(data);
  });
  // generate Order Table
  function generateOrderTable(element){ 
  console.log(element);
  var base_url = $('#base_url').val();
    jQuery.ajax({
     url: base_url + 'email_sms_blast/getOrderList',
      data: {'name' : element.name , 'email' : element.email, 'phone_number' : element.phone_number , 'provider_name' : element.provider_name, 'facility_name' : element.facility_name, 'visited_date' : element.visited_date},
      type: 'post', 
      dataType: 'json',
      beforeSend: function () {
        jQuery('#render-list-of-order').html('<div class="text-center mrgA padA"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i></div>');
      },       
      success: function (html) {
        var dataTable='<table id="table_grid1" class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" width="100%" cellspacing="0"></table>';
        jQuery('#render-list-of-order').html(dataTable);    
        var table = $('#order-datatable').DataTable({
          data: html.data,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": false,
          "bInfo": true,
          "bAutoWidth": true,
          columns: [
            { title: "Name", "width": "16%"},
            { title: "Email.", "width": "16%"},
            { title: "Phone Number", "width": "16%"},
            { title: "Provider Name", "width": "16%"},         
            { title: "Facility Name", "width": "16%"},
			{ title: "Visited Date", "width": "16%"}
          ],        
        });
      }    
    });
  } */
  
  
   // default render page
  jQuery(document).ready(function() {
   var data = {name:"", email:"", phone_number:"", provider_name:"", facility_name:"", visited_date:""};
    generateOrderTable(data);
  });
 
  // render date datewise
  jQuery(document).on('click','#filter_email_filter', function(){  
    var name = jQuery('input#filter-name').val();    
    var email = jQuery('input#filter-email').val();
    var phone_number = jQuery('input#filter-phone-number').val();    
    var provider_name = jQuery('input#filter-provider-name').val();
	var facility_name = jQuery('input#filter-facility-name').val();
	var visited_date = jQuery('input#filter-visited-date').val();
	alert(visited_date);
    var data = {name:name, email:email, phone_number:phone_number, provider_name:provider_name, facility_name:facility_name, visited_date:visited_date};
    generateOrderTable(data);
  });
  // generate Order Table
  function generateOrderTable(element){ 
  var base_url = $('#base_url').val();
    jQuery.ajax({
      url: base_url + 'email_sms_blast/get_table',
      data: {'name' : element.name , 'email' : element.email, 'phone_number' : element.phone_number , 'provider_name' : element.provider_name, 'facility_name' : element.facility_name, 'visited_date' : element.visited_date},
      type: 'post', 
      dataType: 'json',
      beforeSend: function () {
        jQuery('#render-list-of-order').html('<div class="text-center mrgA padA"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i></div>');
      },       
      success: function (html) {
        var dataTable='<table id="order-datatable" class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" width="100%" cellspacing="0"></table>';
        jQuery('#render-list-of-order').html(dataTable);    
        var table = $('#order-datatable').DataTable({
          data: html.data,
		  "pageLength": 100,
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": false,
          "bInfo": true,
          "bAutoWidth": true,
          columns: [
			{ title: "Check Box", "width": "2%"},
            { title: "Name", "width": "15%"},
            { title: "Email.", "width": "15%"},
            { title: "Phone Number", "width": "15%"},
            { title: "Provider Name", "width": "15%"},         
            { title: "Facility Name", "width": "15%"},
			{ title: "Visited Date", "width": "15%"}
          ],        
        });
      }    
    });
  }
