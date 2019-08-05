function readmorebtn() {
	1 == $("#readmore_btn").prop("checked") ? ($("#readmoreurl").show(), $("#readmore_url").attr("required", "required")) : ($("#readmoreurl").hide(), $("#readmore_url").removeAttr("required"))
}

function text_image_developer() {
	$("#text_image_developer").slideToggle()
}
$(document).ready(function () {
	$(function () {
		$("#image").observe_field(1, function () {
			var e = $("#image_url").val(),
				r = $("#httpUrl").val(),
				a = this.value.replace(e, "");
			$("#image").val(a);
			var t = a.replace(r + "/images/", "thumbs/");
			$("#image_preview").attr("src", e + t).show(), 0 == t.length ? $("#image_preview2").attr("src", e + "images/noimage.png") : $("#image_preview2").attr("src", e + t)
		})
	}), $("#btn_ok").click(function () {
		var e = $("#text-image-id").val(),
			r = $("#image_url").val(),
			a = r.replace("assets/", "admin/");
		$.ajax({
			type: "POST",
			url: a + "Text_image/remove_image",
			data: {
				id: e
			},
			cache: !1,
			success: function (e) {
				$("#image").val(""), $("#show_image1").hide(), $("#show_image2").show(), $("#imageRemove").hide(), $("#confirm-delete").modal("hide"), $("#image_preview2").attr("src", r + "images/noimage.png"), 1 == e && new PNotify({
					title: "Logo Deleted",
					text: "Just to let you know, Logo Deleted Successfully.",
					type: "info",
					styling: "bootstrap3"
				})
			}
		})
	})
}), CKEDITOR.replace("text", {
    toolbar: [{
        name: "basicstyles",
        groups: ["basicstyles", "cleanup"],
        items: ["Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "-"]
    }, {
        name: "paragraph",
        groups: ["list", "indent", "blocks", "align", "bidi"],
        items: ["NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote", "-", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock", "-", "BidiLtr", "BidiRtl", "Language"]
    }, {
        name: "links",
        items: ["Link", "Unlink", "Anchor"]
    }, {
        name: "insert",
        items: ["Image", "Table", "HorizontalRule", "PageBreak", "Iframe"]
    }, {
        name: "styles",
        items: ["Styles", "Format", "Font", "FontSize"]
    }, {
        name: "about",
        items: ["About"]
    }],
    extraPlugins: "wordcount",
    wordcount: {
        showCharCount: !0,
        showWordCount: !0
        //maxCharCount: 600
    },
    removeButtons: "Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar"
});

CKEDITOR.replace("text2", {
		toolbarGroups: [{
			name: "basicstyles",
			groups: ["basicstyles"]
		}, {
			name: "styles",
			groups: ["styles"]
		}, {
			name: "about",
			groups: ["about"]
		}],
		extraPlugins: "wordcount",
		wordcount: {
			showCharCount: !0,
			showWordCount: !0
		},
		removeButtons: "Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar"
	});
