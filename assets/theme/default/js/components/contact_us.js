// Contact us
// Includes : Google Captcha
function contactButtonHover(t, e, o, a, n) {
    var c = "footer_contact" != n ? "contact_us_submit" : "footer_contact_us_submit";
    $("#" + c).removeClass(t), $("#" + c).removeClass(e), $("#" + c).addClass(o), $("#" + c).addClass(o)
}

function contactButtonHoverOut(t, e, o, a, n) {
    var c = "footer_contact" != n ? "contact_us_submit" : "footer_contact_us_submit";
    $("#" + c).removeClass(o), $("#" + c).removeClass(a), $("#" + c).addClass(t), $("#" + c).addClass(e)
}

function captcha_refresh() {
    var t = $(".captcha-refresh").find("#captcha_refresh"),
        e = "captcha-refresh-animate";
    t.addClass(e), window.setTimeout(function () {
        t.removeClass(e)
    }, 200), $.get("contact_us/refresh", function (t) {
        $("#image_captcha").html(t)
    })
}! function () {
    var t = "___grecaptcha_cfg";
    window[t] || (window[t] = {});
    var e = "grecaptcha";
    window[e] || (window[e] = {}), window[e].ready = window[e].ready || function (e) {
        (window[t].fns = window[t].fns || []).push(e)
    }, (window[t].render = window[t].render || []).push("onload"), window.__google_recaptcha_client = !0;
    var o = document.createElement("script");
    o.type = "text/javascript", o.async = !0, o.src = "https://www.gstatic.com/recaptcha/api2/v1529908317173/recaptcha__en.js";
    var a = document.querySelector("script[nonce]"),
        n = a && (a.nonce || a.getAttribute("nonce"));
    n && o.setAttribute("nonce", n);
    var c = document.getElementsByTagName("script")[0];
    c.parentNode.insertBefore(o, c)
}(), $("#contact_form, #footer_contact_form").on("submit", function (t) {
    t.preventDefault(), $.ajax({
        url: "contact_us/insert_contact_us",
        type: "post",
        data: $(this).serialize(),
        beforeSend: function () {
            $("#contact_us_loader").removeClass("hide")
        },
        success: function (t) {
            $("#contact_us_loader").addClass("hide");
            try {
                var e = JSON.parse(t)
            } catch (e) {
                window.location.href = t
            }

            console.log(e);

            1 == e.code ? setTimeout(function () {
                swal({
                    title: e.title,
                    text: e.message,
                    type: e.type,
                    allowOutsideClick: !1
                }).then(function () {
                    location.href = e.page_url
                })
            }, 1e3) : 0 == e.code && setTimeout(function () {
                swal({
                    text: e.message,
                    timer: 2e3,
                    showCancelButton: !1,
                    showConfirmButton: !1
                }).then(function () {})
            })
        }
    })
});