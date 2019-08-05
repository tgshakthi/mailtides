$(document).ready(function() {
	// Datatable - One ( Master Campaign )
	if ($('#datatable-buttons').length) {
		var table = $('#datatable-buttons').DataTable({
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'csvHtml5',
					text: 'Export CSV',
					filename: 'patient-files',
					className: 'btn-sm',
					exportOptions: {
						columns: [1, 2, 3]
					}
				}
			],
			orderCellsTop: true,
			responsive: !0
		});

		// Datepicker - Master Campaign
		$('#min').datepicker({
			onSelect: function() {
				table.draw();
			},
			changeMonth: true,
			changeYear: true
		});
		$('#max').datepicker({
			onSelect: function() {
				table.draw();
			},
			changeMonth: true,
			changeYear: true
		});

		// Datatable - One ( Master Campaign Datepicker Filter)
		$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
			var min = $('#min').datepicker('getDate');
			var max = $('#max').datepicker('getDate');
            var startDate = new Date(data[3]);
            alert(startDate);
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

		// Clone Previous Row for filter input
		$('#datatable-buttons>thead>tr')
			.clone(true)
			.appendTo('#datatable-buttons thead');
		$('#datatable-buttons>thead>tr:eq(1)>th').each(function(i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'Action' && title != 'Status') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function() {
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
		$('#min, #max').change(function() {
			table.draw();
		});
	}

	// Datatable - Two ( Campaign )
	if ($('#datatable-campaign-users').length) {
		var tableTwo = $('#datatable-campaign-users').DataTable();

		// Datepicker for Campaign
		$('#min-campaign-users').datepicker({
			onSelect: function() {
				tableTwo.draw();
			},
			changeMonth: true,
			changeYear: true
		});
		$('#max-campaign-users').datepicker({
			onSelect: function() {
				tableTwo.draw();
			},
			changeMonth: true,
			changeYear: true
		});

		$.fn.dataTable.ext.search.push(function(settings, dataTwo, dataIndex) {
			var minTwo = $('#min-campaign-users').datepicker('getDate');
			var maxTwo = $('#min-campaign-users').datepicker('getDate');
			var startDateTwo = new Date(dataTwo[3]);

			alert(startDateTwo);

			if (minTwo == null && maxTwo == null) {
				return true;
			}
			if (minTwo == null && startDateTwo <= maxTwo) {
				return true;
			}
			if (maxTwo == null && startDateTwo >= minTwo) {
				return true;
			}
			if (startDateTwo <= maxTwo && startDateTwo >= minTwo) {
				return true;
			}
			return false;
		});

		$('#datatable-campaign-users>thead>tr')
			.clone(true)
			.appendTo('#datatable-campaign-users thead');
		$('#datatable-campaign-users>thead>tr:eq(1)>th').each(function(i) {
			var title = $(this).text();
			if (title.length > 0 && title != 'S.No') {
				$(this).html(
					'<input type="text" placeholder="Search ' + title + '" />'
				);
				$('input', this).on('keyup change', function() {
					console.log(this.value);
					if (tableTwo.column(i).search() !== this.value) {
						tableTwo
							.column(i)
							.search(this.value)
							.draw();
					}
				});
			}
		});

		// Event listener to the two range filtering inputs to redraw on input
		$('#min-campaign-users, #max-campaign-users').change(function() {
			tableTwo.draw();
		});
	}
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
	var googleReviews = document.getElementById('mail-google');
	var facebookReviews = document.getElementById('mail-facebook').value;
	var mailSent = document.getElementById('mail-sent').value;

	new Chart(f, {
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
			datasets: [
				{
					backgroundColor: [
						'#26B99A',
						'#EE82EE',
						'#DA70D6',
						'#006600',
						'#CC0066',
						'#000099'
					],
					data: [
						mailSent,
						opened,
						notOpened,
						txgidocsReviews,
						commentsPosted,
						commentsNotPosted
					]
				}
			]
		},
		options: {
			legend: {
				display: false
			},
			scales: {
				yAxes: [
					{
						ticks: {
							beginAtZero: !0
						}
					}
				]
			}
		}
	});
}

// Email Template Preview
$('#preview_template').click(function() {
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
			success: function(data) {
				if (data != 0) {
					if (data == 1) {
						var img =
							'<img class="preview-template-img" src="' +
							imageUrl +
							'images/txgidocs/mail-template/digestive-and-liver-disease-consultants-template.png">';
						$('#preview-template-modal').modal('show');
						$('#modal-body-img').html(img);
					}

					if (data == 2) {
						var img =
							'<img class="preview-template-img" src="' +
							imageUrl +
							'images/txgidocs/mail-template/google-template.png">';
						$('#preview-template-modal').modal('show');
						$('#modal-body-img').html(img);
					}

					if (data == 3) {
						var img =
							'<img class="preview-template-img" src="' +
							imageUrl +
							'images/txgidocs/mail-template/facebook-template.png">';
						$('#preview-template-modal').modal('show');
						$('#modal-body-img').html(img);
					}
				}
			}
		});
	} else {
		alert('Please Select Campaign.');
	}
});

$(document).ready(function() {
	$('#campaign_id').on('change', function() {
		var selectedId = $(this).val();
		$('#hidden-selected-id').val(selectedId);
	});

	// Preview Template Campaign

	$('#preview-template-campaign').click(function() {
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
$(document).ready(function() {
	var baseUrl = $('#base-url').val();
	$('#wizard').smartWizard('fixHeight');

	// Add classes to buttons
	$('.buttonNext').addClass('btn btn-success'),
		$('.buttonPrevious').addClass('btn btn-primary'),
		$('.buttonFinish').addClass('btn btn-default');
});

$('#filter-data-import').click(function() {
	var values = $("input[name='row_sort_order[]']")
		.map(function() {
			return $(this).val();
		})
		.get();
	// var x = $('input[name="row_sort_order[]"]').val();
	console.log(values);
});
