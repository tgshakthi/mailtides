<!-- page content -->
<div class="right_col" role="main">
	<div id="overlay"></div>
  	<div class="mega_slider">
    	<div id="success_msg" class="success_msg"></div>
    
    	<div class="head_bg_img">
      		<div class="file-upload">
        		<label for="image_upload" class="file-upload__label"><i class="fa fa-upload" aria-hidden="true"></i></label>
        		<?php
				echo form_input(
					array(
						'type' => 'file',
						'name' => 'image_upload',
						'id' => 'image_upload',
						'class'	=> 'file-upload__input',
						'multiple' => 'multiple'
					)
				);
                ?>
        		<input type="hidden" name="upload_path" id="upload_path" value="<?php echo $upload_path; ?>" />
        		<input type="hidden" name="image_width" id="image_width" value="120" />
        		<input type="hidden" name="image_height" id="image_height" value="80" />
        		<input type="hidden" name="image_data" id="image_data" value="" />
      		</div>
      		<div class="top_toolbar">
        		<input type="hidden" name="base_url" value="<?php echo str_replace('/admin/', '', base_url()); ?>" />
        		<input type="hidden" name="x" value="" />
        		<input type="hidden" name="y" value="" />
        		<input type="hidden" name="w" value="" />
        		<input type="hidden" name="h" value="" />
        		<input type="hidden" name="crop_image_width" value="100" />
        		<input type="hidden" name="crop_image_height" value="100" />
        		<ul class="mega_slider_withheight_left">
          			<li>
            			<input type="number" id="make_image_width" class="image_width_height" value="500" placeholder="Image Width" />
          			</li>
          			<li>
            			<input type="number" id="make_image_height" class="image_width_height" value="500" placeholder="Image Height" />
          			</li>
        		</ul>
        
        		<ul class="image_format">
            		<!--<li>
            			<button id="save_images">Save</button>
          			</li>-->
         			<li>
            			<input id="your_pic_name" type="text" value="" placeholder="Your Picture Name"/>
          			</li>
          			<li>
            			<select id="select_image_type">
              				<option value="">Select Image Type</option>
              				<option value="jpg">. jpg</option>
              				<option value="png">. png</option>
            			</select>
          			</li>
          			<li>
            			<button id="upload_download">Upload or Download</button>
            			<ul id="upload_download_contain" class="upload_download_contain">
              				<li><a id="click_to_upload" href="javascript:void(0)">Click To Upload</a></li>
              				<li><a id="click_to_download" href="javascript:void(0)">Click To Download</a></li>
            			</ul>
          			</li>
        		</ul>
      		</div>
    	</div>
    
    	<div class="image_custom">
    
      		<div class="upload_image_preview" id="upload_image_preview">
       			<div class="fake tool text tool-1 text_icon_image"><i class="fa fa-text-width" aria-hidden="true"></i></div>
        		<input id="page_bg_color" class="page_bg_color" value="" />
                <div class="fake tool shape tool-3" style="width:30px; height:30px; border:2px solid #ccc"></div>
                <!--<div class="fake tool shape tool-3 circle" style="width:30px; height:30px; border-radius:50%; border:1px solid #ccc"></div>-->
                
                <style>
				.triangle
				{
					width:0px;
					height:0px;
					border-left: 50px solid transparent;
					border-right: 50px solid transparent;
					border-bottom: 100px solid red;
				}
				</style>
        		<div id="image_gallery" class="image_gallery">
          			<?php
					$imagelists = glob($upload_path."*.{jpg,gif,png}", GLOB_BRACE);
					foreach($imagelists as $imagelist)
					{
						$image_name = basename($imagelist);
						?>
          				<a href="javascript:void(0)"><img class="fake tool image tool-2" id="img" src='<?php echo $imagelist; ?>' alt='<?php echo $image_name; ?>'/></a>
          				<?php
					}
					?>
        		</div>
      		</div>
      		<div class="f_right_image">
      			<ul class="tool_bar" id="tool_bar">
      			</ul>
      			
                <div class="image_custom_area" id="image_custom_area">
					<?php
                    if(!empty($image_customizations))
                    {
						$i = 1;
                        foreach($image_customizations as $image_customization)
                        {
                            ?>
                            <div> <?php echo $image_customization->custom_html; ?> </div>
                            <?php
							$i++;
                        }
                    }
					else
					{
						?>
                        <div>
                            <div class="make_image_div" id="make_image_div_1">
                                <div class="scroll_bar">
                                    <div class="scroll_box">
                                        <div class="make_image" id="make_image_1"></div>
                                    </div>
                                    <div class="make_image_custom" id="make_image_custom_1">
                                        <p>1</p>
                                        <i class="fa fa-trash" aria-hidden="true"></i> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
					}
                    ?>
                </div>
                
      
      			<div class="add_page_new">
        			<input type="hidden" name="active_page" value="<?php echo $active_page; ?>" />
        			<input type="hidden" name="page_count" value="<?php echo $page_count; ?>" />
        			<button id="add_new_page">+ Add a new page</button>
        			<a href="javascript:void(0)" id="page_up"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
        			<a href="javascript:void(0)" id="page_down"><i class="fa fa-chevron-down" aria-hidden="true"></i></a> 
     			</div>
        	</div>
        
        	<br class="spacer"/>
        
    	</div>
  	</div>
</div>
<!-- Page Content -->