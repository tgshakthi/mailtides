function circular_image_option(){$("#circular_image_option").slideToggle()}$(document).ready(function(){$(function(){$("#image").observe_field(1,function(){var e=$("#image_url").val(),a=$("#httpUrl").val(),i=this.value.replace(e,"");$("#image").val(i);var t=i.replace(a+"/images/","thumbs/");$("#image_preview").attr("src",e+t).show(),0==t.length?$("#image_preview2").attr("src",e+"images/noimage.png"):$("#image_preview2").attr("src",e+t)})}),$("#btn_ok").click(function(){var e=$("#website_id").val(),a=$("#image_url").val(),i=a.replace("assets/","admin/");$.ajax({type:"POST",url:i+"map/remove_image",data:{id:e},cache:!1,success:function(e){$("#image").val(""),$("#show_image1").hide(),$("#show_image2").show(),$("#imageRemove").hide(),$("#confirm-delete").modal("hide"),$("#image_preview2").attr("src",a+"images/noimage.png"),1==e&&new PNotify({title:"Image Deleted",text:"Just to let you know, Image Deleted Successfully.",type:"info",styling:"bootstrap3"})}})})});