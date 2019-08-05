function readmorebtn() {
  1 == $('#readmore_btn').prop('checked')
    ? ($('#readmoreurl').show(),
      $('#readmore_url').attr('required', 'required'))
    : ($('#readmoreurl').hide(), $('#readmore_url').removeAttr('required'));
}
function text_image_developer() {
  $('#text_image_developer').slideToggle();
}
$(document).ready(function() {
  $(function() {
    $('#image').observe_field(1, function() {
      var e = $('#image_url').val(),
        r = $('#httpUrl').val(),
        a = this.value.replace(e, '');
      $('#image').val(a);
      var t = a.replace(r + '/images/', 'thumbs/');
      $('#image_preview')
        .attr('src', e + t)
        .show(),
        0 == t.length
          ? $('#image_preview2').attr('src', e + 'images/noimage.png')
          : $('#image_preview2').attr('src', e + t);
    });
  });
}),
  CKEDITOR.replace('text', {
    toolbarGroups: [
      { name: 'basicstyles', groups: ['basicstyles'] },
      { name: 'links', groups: ['links'] },
      { name: 'paragraph', groups: ['list', 'blocks'] },
      { name: 'document', groups: ['mode'] },
      { name: 'insert', groups: ['insert'] },
      { name: 'styles', groups: ['styles'] },
      { name: 'about', groups: ['about'] }
    ],
    extraPlugins: 'wordcount',
    wordcount: {
      showCharCount: !0,
      showWordCount: !0
      //maxCharCount: 250
    },
    removeButtons:
      'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
  });
