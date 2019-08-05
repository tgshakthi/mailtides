function redirectbtn() {
	1 == $("#redirect").prop("checked") ? ($("#redirect_url").show(), $("#redirect").attr("required", "required")) : ($("#redirect_url").hide(), $("#redirect").removeAttr("required"))
}

$(document).ready(function () {
	$(function () {
		$("#image").observe_field(1, function () {
			var e = $("#image_url").val(),
				i = $("#httpUrl").val(),
				r = this.value.replace(e, "");
			$("#image").val(r);
			var t = r.replace(i + "/images/", "thumbs/");
			$("#image_preview").attr("src", e + t).show(), 0 == t.length ? $("#image_preview2").attr("src", e + "images/noimage.png") : $("#image_preview2").attr("src", e + t)
		})
	})
});
