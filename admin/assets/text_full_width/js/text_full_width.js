$(document).ready(function(){$(function(){$("#image").observe_field(1,function(){var e=$("#image_url").val(),a=$("#httpUrl").val(),r=this.value.replace(e,"");$("#image").val(r);var s=r.replace(a+"/images/","thumbs/");$("#image_preview").attr("src",e+s).show(),0==s.length?$("#image_preview2").attr("src",e+"images/noimage.png"):$("#image_preview2").attr("src",e+s)})})}),CKEDITOR.replace("full-text",{toolbarGroups:[{name:"basicstyles",groups:["basicstyles"]},{name:"links",groups:["links"]},{name:"paragraph",groups:["list","blocks"]},{name:"document",groups:["mode"]},{name:"insert",groups:["insert"]},{name:"styles",groups:["styles"]},{name:"about",groups:["about"]}],removeButtons:"Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar"});