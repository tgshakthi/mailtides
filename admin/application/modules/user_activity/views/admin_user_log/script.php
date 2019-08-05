 
    
	<!-- jQuery -->
	<?php
		//include('../assets/user_activity/js');	
	?>	
    <script src="<?php echo base_url() ;?>assets/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ;?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url() ;?>assets/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url() ;?>assets/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url() ;?>assets/user_activity/build/js/custom.min.js"></script>
	<!-- jQuery custom content scroller -->

	<script src="<?php echo base_url() ;?>assets/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
	
	 <!-- iCheck -->
    <script src="<?php echo base_url() ;?>assets/iCheck/icheck.min.js"></script>
	
	
	
	
<script>
function alpha_val_click(search_val)
{

	var searchval_alpha = search_val;
	if(searchval_alpha != "")
	{
		$.ajax({
			type    : "POST",
			url     : "<?php echo base_url() ;?>/index.php/user_activity/Admin_user_log/search_alpha_values",
			data    : {searchval_alpha:searchval_alpha},
			success : function(data12)
			{
					
					$("#search_data").html(data12);	
				
				
			} 
		});
	}else
		{
			
			//$("#search_data").hide();	
		}
		
}
	
</script>	
		
<script>
function search_user_details()
{
	var searchval = $("#search_details").val();
	if(searchval.length > 1)
	{
		$.ajax({
			type    : "POST",
			url     : "<?php echo base_url() ;?>/index.php/user_activity/Admin_user_log/search_values",
		//	dataType: 'application/json',
			data    : {searchval:searchval},
			success : function(data)
			{
				
				$("#search_data").html(data);	
				
				
			} 
		});
	}
	else
	{
		//$("#search_data").html("");		
	}
}
</script>		
		