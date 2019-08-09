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

		var table = $('#datatable-buttons').DataTable({
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

		//Event listener to the two range filtering inputs to redraw on input
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

		var table = $('#datatable-campaign-users').DataTable();

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
		var baseUrl = $('#base-url').val();
		var campaignName = $('#campaign-name').val();
		var campaignDesc = CKEDITOR.instances['text'].getData();
		var campaignType = $('#campaign-type').val();
		var sendDate = $('#send-date').val();

		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();
		if (campaignName.length > 0) {
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: baseUrl + 'email_blast/import_filter_data',
					data: {
						campaign_name: campaignName,
						campaign_desc: campaignDesc,
						campaign_type: campaignType,
						send_date: sendDate,
						user_id: values
					},
					success: function (data) {
						if (data.length > 0) {
							$('#campaign-id').val(data);
							alert('Successfully Imported. Go to Step - 3');
							document.getElementById('filter-data-import').disabled = true;
						} else {
							alert('Something Went Wrong!. Please try again!.');
							window.location.href = baseUrl + 'email_blast/add_edit_campaign';
						}
					}
				});
			} else {
				alert('please upload some users!');
			}
		} else {
			alert('Please Enter Campaign Name.');
		}

	});

	// Send Date Datepicker
	$('#send-date').datepicker();

	// Smart Wizard
	var baseUrl = $('#base-url').val();
	$('#wizard').smartWizard({
		autoAdjustHeight: true, // Automatically adjust content height
		onFinish: onFinishCallback,
		hideButtonsOnDisabled: true,
	});

	function onFinishCallback() {
		var baseUrl = $('#base-url').val();
		var campaignId = $('#campaign-id').val();
		var campaignName = $('#campaign-name').val();
		var campaignDesc = CKEDITOR.instances['text'].getData();
		var campaignType = $('#campaign-type').val();
		var sendDate = $('#send-date').val();
		var emailTemplate = $('#email-template').val();

		var values = $("input[name='row_sort_order[]']")
			.map(function () {
				return $(this).val();
			})
			.get();

		if (campaignName.length > 0 && emailTemplate.length > 0) {
			if (values.length > 0) {
				$.ajax({
					method: 'POST',
					url: baseUrl + 'email_blast/insert_campaign_data',
					data: {
						campaign_id: campaignId,
						campaign_name: campaignName,
						campaign_desc: campaignDesc,
						campaign_type: campaignType,
						send_date: sendDate,
						user_id: values,
						email_template: emailTemplate
					},
					success: function (data) {
						window.location.href = baseUrl + 'email_blast/campaign';
					}
				});
			}
		} else {
			alert('Something Went Wrong!. Please try again!.');
			window.location.href = baseUrl + 'email_blast/add_edit_campaign';
		}

	}

	// Add classes to buttons
	$('.buttonNext').addClass('btn btn-success'),
		$('.buttonPrevious').addClass('btn btn-primary'),
		$('.buttonFinish').addClass('btn btn-default').text('Save');
});

// Graphical Reports
if ($('#mybarChart').length) {
	
	var f = document.getElementById('mybarChart');

	var opened = document.getElementById('mail-opened').value;
	var notOpened = document.getElementById('mail-unopened').value;
	var commentsPosted = document.getElementById('mail-comments-posted').value;
	var commentsNotPosted = document.getElementById('mail-comments-not-posted')
		.value;
	var txgidocsReviews = document.getElementById('mail-txgidocs').value;
	var googleReviews = document.getElementById('mail-google').value;
	var facebookReviews = document.getElementById('mail-facebook').value;
	var mailSent = document.getElementById('mail-sent').value;
  


	function campaign(e) {
		var baseUrl = $('#base_url').val();
		
		$.ajax({

			method: 'POST',
			url: baseUrl + 'email_blast/graphical_campaign_id',
			data: {
				campaign_id: e
			},
			cache: false,
			success: function (data) {
                  
				var campaignData = JSON.parse(data);
                
				var chartData = [];

				chartData.push(campaignData.sent);
				chartData.push(campaignData.opened);
				chartData.push(campaignData.not_opened);
			
				chartData.push(campaignData.link_open);
			
				
				chartData.push(campaignData.posted);
				chartData.push(campaignData.not_posted);

				var chart = new Chart(f, {
					type: 'bar',
					data: {
						labels: [
							'Sent',
							'Opened',
							'Unopened',
							'Link Opened',
							'Comments Posted',
							'Comments Not Posted'
						],
						datasets: [{
							backgroundColor: [
								'#26B99A',
								'#EE82EE',
								'#DA70D6',
								'#006600',
								'#CC0066',
								'#000099'
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
								beginAtZero:true
            }
        }]
    }
}
				});

			}
		});
	}
}







//onchage function for campaign id


// Email Template Preview
$('#preview_template').click(function () {
	var campaignId = $('#hidden-selected-id').val();
	var baseUrl = $('#base_url').val();
	var imageUrl = $('#image_url').val();

	if (campaignId.length > 0) {
		$.ajax({
			method: 'POST',
			url: baseUrl + 'email_blast/get_campaign_template',
			data: {
				campaign_id: campaignId
			},
			success: function (data) {
				if (data != 0) {

					var img =
						'<img class="preview-template-img" src="' +
						imageUrl +
						'images/txgidocs/' + data + '">';
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

// Smart Wizard
$(document).ready(function () {

});

$(document).ready(function () {
	// Logo Preview
	$(function () {
		$('#image').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, "");
			$("#image").val(res);
			var res1 = res.replace(httpUrl + '/images/', "thumbs/");
			$('#image_preview').attr('src', image_url + res1).show();
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
			url: siteUrl + 'email_blast/remove_email_template_image',
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#image').val("");
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
		$('#loader').removeClass('loader hidden').addClass('done');

	});
});



// Email Tracking Datatable Filter
if ($('#datatable-email').length) {

	$('#datatable-email').DataTable({
		initComplete: function () {
			this.api().columns(2).every(function () {
				var column = this;
				if (column.index() == 2) {
					var select = $('<select><option value=""></option></select>')
						.appendTo($("#filters").find("th").eq(column.index()))
						.on('change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);

							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();

						});

					column.data().unique().sort().each(function (d, j) {
						select.append('<option value="' + d + '">' + d + '</option>')
					});
				}
			});
		}
	});
}


$('#campaign-name').blur(function () {
	$('#error').html('');
	var base_url = $('#base-url').val();
	var Name = $(this).val();

	if (Name.length != 0) {

		$.ajax({
			type: 'POST',
			url: base_url + 'email_blast/check_campaign_name',
			data: {
				campaign_name: Name

			},
			success: function (data) {

				if (data == 0) {
					$('#error').html('<p style="color:green;font-size: 14px;font-weight:bold">Campaign Name is Available.</p>');
				} else {

					$('#error').html('<p style="color:red;font-size: 14px; font-weight:bold;"> Campaign Name Already Exists.</p>');
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
    var website_id=$('#website_id').val();
	if (Name.length != 0) {

		$.ajax({
			type: 'POST',
			url: base_url + 'email_blast/check_campaign_type_name',
			data: {
				campaign_name: Name,
				website_id:website_id

			},
			success: function (data) {

				if (data == 0) {
					$('#error').html('<p style="color:green;font-size: 12px;position:absolute;font-weight:bold; top:0">Campaign Name is Available.</p>');
				} else {

					$('#error').html('<p  style="color:red;font-size: 12px;position:absolute;font-weight:bold; top:0"> Campaign Name Already Exists.</p>');
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

	var opened = document.getElementById('mail-opened-type').value;
	var notOpened = document.getElementById('mail-unopened-type').value;
	var commentsPosted = document.getElementById('mail-comments-posted-type').value;
	var commentsNotPosted = document.getElementById('mail-comments-not-posted-type')
		.value;
	var txgidocsReviews = document.getElementById('mail-txgidocs-type').value;
	var googleReviews = document.getElementById('mail-google-type').value;
	var facebookReviews = document.getElementById('mail-facebook-type').value;
	var mailSent = document.getElementById('mail-sent-type').value;
  


	function campaign_type(m) {
	
		var baseUrl = $('#base_url').val();
		
		$.ajax({

			method: 'POST',
			url: baseUrl + 'email_blast/graphical_campaign_type',
			data: {
				campaign_type_id: m
			},
			cache: false,
			success: function (data) {
				
				 var campaignData = JSON.parse(data);
                  var chartData = [];

				 chartData.push(campaignData.users);
				// chartData.push(campaignData.opened);
				// chartData.push(campaignData.not_opened);
			
				// chartData.push(campaignData.link_open);
			
				
				// chartData.push(campaignData.posted);
				// chartData.push(campaignData.not_posted);

				var chart = new Chart(f, {
					type: 'bar',
					data: {
						labels: [
							// 'Sent'
						      'Opened'
							// 'Unopened',
							// 'Link Opened',
							// 'Comments Posted',
							// 'Comments Not Posted'
						],
						datasets: [{
							backgroundColor: [
								// '#26B99A'
								 '#EE82EE'
								// '#DA70D6',
								// '#006600',
								// '#CC0066',
								// '#000099'
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
									beginAtZero: !0
								}
							}]
						}
					}
				});

			}
		});
	}

	
}
