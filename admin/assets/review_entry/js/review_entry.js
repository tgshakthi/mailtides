function readmorebtn() {
    1 == $("#readmore_btn").prop("checked") ? ($("#readmoreurl").show(), $("#readmore_url").attr("required", "required")) : ($("#readmoreurl").hide(), $("#readmore_url").removeAttr("required"))
}

function newsletter_developer() {
    $("#newsletter_developer").slideToggle()
}
if ($("#border_status").on("change", function() {
        1 == $(this).prop("checked") ? $("#bordersizecolor").show() : $("#bordersizecolor").hide()
    }),

 CKEDITOR.replace("text", {
        toolbarGroups: [{
            name: "basicstyles",
            groups: ["basicstyles"]
        }, {
            name: "links",
            groups: ["links"]
        }, {
            name: "paragraph",
            groups: ["list", "blocks"]
        }, {
            name: "document",
            groups: ["mode"]
        }, {
            name: "insert",
            groups: ["insert"]
        }, {
            name: "styles",
            groups: ["styles"]
        }, {
            name: "about",
            groups: ["about"]
        }],
        removeButtons: "Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar"
    }), null == (choosemore = $("#count_to:last").val())) var choosemore = $("#select_options").val(),
    to = $("#field_selectoptions_" + choosemore).size();
else to = parseInt(choosemore);

function add_moreto() {
    var e = '<div class="row" id="form_toid_' + to + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="carbon_copy" name="to_address[]" placeholder="Add To Address" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldsto(' + to + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
    return $("#result_fieldto").append(e), to++, !1
}

function remove_from_fieldsto(e) {
    $("#form_toid_" + e).remove()
}
if (null == (choosemore = $("#count_cc:last").val())) {
    choosemore = $("#select_options").val();
    var cc = $("#field_selectoptions_" + choosemore).size()
} else cc = parseInt(choosemore);

function add_morecc() {
    var e = '<div class="row" id="form_ccid_' + cc + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="carbon_copy" name="carbon_copy[]" placeholder="Add CC" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldscc(' + cc + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
    return $("#result_fieldcc").append(e), cc++, !1
}

function remove_from_fieldscc(e) {
    $("#form_ccid_" + e).remove()
}
if (null == (choosemore = $("#count_bcc:last").val())) {
    choosemore = $("#select_options").val();
    var bcc = $("#field_selectoptions_" + choosemore).size()
} else bcc = parseInt(choosemore);

function add_morebcc() {
    var e = '<div class="row" id="form_bccid_' + bcc + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="blind_carbon_copy" name="blind_carbon_copy[]" placeholder="Add BCC" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldsbcc(' + bcc + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
    return $("#result_fieldbcc").append(e), bcc++, !1
}

function remove_from_fieldsbcc(e) {
    $("#form_bccid_" + e).remove()
}
$(function() {
    $("#image").observe_field(1, function() {
        var e = $("#image_url").val(),
            o = $("#httpUrl").val(),
            c = this.value.replace(e, "");
        $("#image").val(c);
        var r = c.replace(o + "/images/", "thumbs/");
        $("#image_preview").attr("src", e + r).show(), 0 == r.length ? $("#image_preview2").attr("src", e + "images/noimage.png") : $("#image_preview2").attr("src", e + r)
    })
});CKEDITOR.replace("newsletter-title", {
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
    removeButtons: "Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar",

});