<link href="<?php echo base_url(); ?>assets/theme/default/css/dependency/sweetalert2.min.css" rel="stylesheet"
    type="text/css" />
<script src="<?php echo base_url(); ?>assets/theme/default/js/dependency/sweetalert2.min.js"></script>
<script>
setTimeout(function() {
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $text; ?>",
        type: "<?php echo $type; ?>",
        allowOutsideClick: false,
    }).then(function() {
        location.href = "<?php echo $url; ?>";
    });
}, 1000);
</script>