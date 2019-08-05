<?php include('include/head.php'); ?>

            	<?php include('include/menu.php'); ?>
                    <form method="post" class="gal_form" id="form" enctype="multipart/form-data">
                        <input type="hidden" name="count_file" id="count_file" value="1" >
                        <input type="hidden" name="upload_folder" id="upload_folder" value="<?php echo $dir; ?>" >
                        <input type="hidden" name="thumb_folder" id="thumb_folder" value="<?php echo $thumb_dir; ?>" >
                        <div class="upload_img">
                            <ul class="up_list">
                                <li id="upload_file_list" style="float:left;">
                                     <div id="upload_file_list_div" class="upload-btn-wrapper">
     									<span class="btn"><i class="fa fa-upload" aria-hidden="true"></i> Upload</span>
 									<input class="fileup" type="file" id="upload_file1" name="upload_file1[]" multiple/>
									</div>
                                </li>
                            </ul>
                        </div>
                        <div class="preview_img" style="display:none" id="output" name="output"></div>
                        <div class="upload_btn" >
                            <input type="submit" class="upload" name="upload_file_btn" id="upload_file_btn" style="display:none" value="Upload" />
                            <a href="javascript:void(0);" style="display:none" id="cancel" onClick="cancelupload()" name="cancel">Cancel</a>
                        </div>
                    </form>
                   
<?php include('include/footer.php'); ?>