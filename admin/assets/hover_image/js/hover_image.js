
$(document).ready(function() {
    $(function() {
        $("#image").observe_field(1, function() {
            var e = $("#image_url").val(),
                r = $("#httpUrl").val(),
                i = this.value.replace(e, "");
            $("#image").val(i);
            var a = i.replace(r + "/images/", "thumbs/");
            $("#image_preview").attr("src", e + a).show(), 0 == a.length ? $("#image_preview2").attr("src", e + "images/noimage.png") : $("#image_preview2").attr("src", e + a)
        })
    })
})
$(document).ready(function() {
    $(function() {
        $("#image1").observe_field(1, function() {
            var e = $("#image_url").val(),
                r = $("#httpUrl").val(),
                i = this.value.replace(e, "");
            $("#image1").val(i);
            var a = i.replace(r + "/images/", "thumbs/");
            $("#image_previews").attr("src", e + a).show(), 0 == a.length ? $("#image_previews2").attr("src", e + "images/noimage.png") : $("#image_previews2").attr("src", e + a)
        })
    })
}), CKEDITOR.replace("text", {
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
        showWordCount: !0,
        maxCharCount: 180
    },
    removeButtons: "Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar"
});