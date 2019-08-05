	<!-- <script src="https://jquery.equalheights.min.js"></script>
	<script src="<?php echo base_url()?>assets/theme/default/zequalheight.js"></script> -->
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   <script>
  AOS.init();
</script>



<script>

$(document).ready(function(){

    // Select and loop the container element of the elements you want to equalise
    $('.footer_all_details').each(function(){

      // Cache the highest
      var highestBox = 0;

      // Select and loop the elements you want to equalise
      $('.f_equal_height', this).each(function(){

        // If this box is higher than the cached highest then store it
        if($(this).height() > highestBox) {
          highestBox = $(this).height();
        }

      });

      // Set the height of all those children to whichever was highest
      $('.f_equal_height',this).height(highestBox);

    });

});

$(document).ready(function () {
  var heightArray = $(".blog-details").map(function () {
    return $(this).height();
  }).get();
  var maxHeight = Math.max.apply(Math, heightArray);
  $(".blog-details").height(maxHeight);
});

$(document).ready(function () {
  var heightArray = $(".event-details").map(function () {
    return $(this).height();
  }).get();
  var maxHeight = Math.max.apply(Math, heightArray);
  $(".event-details").height(maxHeight);
});
$(document).ready(function () {
  var heightArray = $(".map-details").map(function () {
    return $(this).height();
  }).get();
  var maxHeight = Math.max.apply(Math, heightArray);
  $(".map-details").height(maxHeight);
});

 
</script>  
	</body>
</html>
