 $(document).ready(function () {

 	$("#star1").click(function () {
 		document.getElementById("rating_star").value = "1";
 		$("i").hasClass(".selected")
 		$("#review-first").css("display", "block");
 		$("#review-second").css("display", "block");
 		$("#review-third").css("display", "none");
 	})

 	$("#star2").click(function () {
 		document.getElementById("rating_star").value = "2";
 		$("i").hasClass(".selected")
 		$("#review-first").css("display", "block");
 		$("#review-second").css("display", "block");
 		$("#review-third").css("display", "none");
 	})

 	$("#star3").click(function () {
 		document.getElementById("rating_star").value = "3";
 		$("i").hasClass(".selected")
 		$("#review-first").css("display", "block");
 		$("#review-second").css("display", "none");
 		$("#review-third").css("display", "block");
 	})
 	$("#star4").click(function () {
 		document.getElementById("rating_star").value = "4";
 		$("i").hasClass(".selected")
 		$("#review-first").css("display", "block");
 		$("#review-second").css("display", "none");
 		$("#review-third").css("display", "block");
 	})

 	document.getElementById("rating_star").value = "5";
 	$("i").hasClass(".selected")
 	$("#review-first").css("display", "block");
 	$("#review-second").css("display", "none");
 	$("#review-third").css("display", "block");
 });

 $(document).ready(function () {

 	var reviewUserId = $('#review_user_id').val();
 	var reviewBaseUrl = $('#review_base_url').val();

 	if (reviewUserId.length != 0) {
 		$.ajax({
 			method: "POST",
 			url: reviewBaseUrl + 'reviews_entry/get_users',
 			data: {
 				id: reviewUserId
 			},
 			success: function (data) {
 				if (data != 0) {
 					var users = JSON.parse(data);
 					var name = users.name;
 					var email = users.email;
 					$('#modal1').modal().modal('open');
 					$('#review_name').val(name).prop("readonly", true);
 					$('#review_email').val(email).prop("readonly", true);
 				}
 			}
 		});
 	} else {
 		// Modal
 		$('.modal').modal();
 	}

 });