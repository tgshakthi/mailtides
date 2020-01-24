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
	if ($('#datatable-buttons').length) {
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
					success: function (data) {
						if (data == '1') {
							alert('Successfully Imported.');
							document.getElementById('filter-sms-data-import').disabled = true;
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
	$('#filter-fb-data-import').click(function () {
		alert();
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
	
	// Email Tracking Datatable Filter
	if ($('#datatable-email').length) {
	// Datatable - One ( Master Campaign Datepicker Filter)		
	var $table = $('#datatable-email').DataTable({
		pageLength: 100,
		initComplete: function () {
			this.api()
				.columns(3)
				.every(function () {
					var column = this;
					if (column.index() == 3) {
						var select = $('<select><option value=""></option></select>')
							.appendTo(
								$('#filters')
								.find('th')
								.eq(column.index())
							)
							.on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex($(this).val());

								column.search(val ? '^' + val + '$' : '', true, false).draw();
							});

						column
							.data()
							.unique()
							.sort()
							.each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>');
							});
					}
				});
			this.api()
				.columns(4)
				.every(function () {
					var column = this;
					if (column.index() == 4) {
						var select = $('<select><option value=""></option></select>')
							.appendTo(
								$('#filters')
								.find('th')
								.eq(column.index())
							)
							.on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex($(this).val());

								column.search(val ? '^' + val + '$' : '', true, false).draw();
							});

						column
							.data()
							.unique()
							.sort()
							.each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>');
							});
					}
				});
			}
			
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min, #max').change(function () {
			table.draw();
		});
	}

// SMS Tracking Datatable Filter
if ($('#datatable-sms').length) {		
var table =	$('#datatable-sms').DataTable({
		pageLength: 100,
		initComplete: function () {
			this.api()
				.columns(3)
				.every(function () {
					var column = this;
					if (column.index() == 3) {
						var select = $('<select><option value=""></option></select>')
							.appendTo(
								$('#filters')
								.find('th')
								.eq(column.index())
							)
							.on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex($(this).val());
								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});

						column
							.data()
							.unique()
							.sort()
							.each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>');
							});
					}
				});
			this.api()
				.columns(4)
				.every(function () {
					var column = this;
					if (column.index() == 4) {
						var select = $('<select><option value=""></option></select>')
							.appendTo(
								$('#filters')
								.find('th')
								.eq(column.index())
							)
							.on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex($(this).val());
								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});

						column
							.data()
							.unique()
							.sort()
							.each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>');
							});
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

	function campaign(e) {
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
	}

}
//onchage function for campaign id
 $(document).ready(function () {
	var option = '<option value="">Select Provider Name</option>';
		$('#campaign_name_data').html(option);
		$('#barchart').hide();
});
//Onchange Function For Template
function campaign_type(value) {
	var baseUrl = $('#base_url').val();
	if (value == "") {
		var option = '<option value="">Select Provider Name</option>';
		$('#campaign_name_data').html(option);
		$('#barchart').hide();
	}else{
		var option = '<option value="">Select Provider Name</option><option value="dldc">DLDC</option><option value="reddy">REDDY</option><option value="hamat">HAMAT</option>';
		$('#campaign_name_data').html(option);
		$('#barchart').hide();
	}	
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

$('#campaign_type').blur(function () {
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
});


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
