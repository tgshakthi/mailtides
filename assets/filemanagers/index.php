<?php 
include('include/head.php'); 
include('popup.php'); 
?>
<div class="file_manager">
	<?php include('include/menu.php'); ?>
	<div class="gridview_listview">
    
    	<?php
		$fileList = glob($dir.'*');
		$folderlists = array_filter($fileList, 'is_dir');
		$imagelists = glob($dir."*.{jpg,gif,png}", GLOB_BRACE);
		?>
		
        <div id="grid_view" class="grid_view comm_list_grid">
        	<?php
			// Folders
			foreach($folderlists as $folder)
			{
				$folder = str_replace($dir, '', $folder);
				?>
                <div class="grid_list_details">
                    <a href="index.php?field_id=<?php echo $field_id; ?>&fldr=<?php echo $getfolder.$folder; ?>" class="file_managericon"><i class="fa fa-folder" aria-hidden="true"></i></a>
                    <div class="grid_view_edit_detele">
                        <a href="javascript:void(0)" title="Rename" onclick="change_folder_name('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $folder; ?>', '')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="dele_icon_colr" href="javascript:void(0)" title="Erase" onclick="erase_folder('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $folder; ?>', '')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                    <a href="javascript:void(0)" class="file_name"><?php echo $folder; ?></a>
                </div>
				<?php
			}
			
			// Images
			foreach($imagelists as $image)
			{
				$extension = pathinfo($image, PATHINFO_EXTENSION);
				$images = str_replace(array($dir, '.'.$extension), array('', ''), $image);
				$thumb_image = str_replace($dir, $thumb_dir, $image);
				
				if(!file_exists($thumb_dir.$images.'.'.$extension))
				{
					$thumb_size  = 100;
					$what = getimagesize($image);
					list($width, $height) = getimagesize($image);
					
					if ($width > $height) 
					{
						$y = 0;
						$x = ($width - $height) / 2;
						$smallestSide = $height;
					}
					else
					{
						$x = 0;
						$y = ($height - $width) / 2;
						$smallestSide = $width;
					}
					
					switch(strtolower($what['mime']))
					{
						case 'image/png':
							$img = imagecreatefrompng($image);
							$new = imagecreatetruecolor($thumb_size, $thumb_size);
							imagecopyresampled($new, $img, 0, 0, $x, $y, $thumb_size, $thumb_size, $smallestSide, $smallestSide);
						break;
						case 'image/jpeg':
							$img = imagecreatefromjpeg($image);
							$new = imagecreatetruecolor($thumb_size, $thumb_size);
							imagecopyresampled($new, $img, 0, 0, $x, $y, $thumb_size, $thumb_size, $smallestSide, $smallestSide);
						break; 
						case 'image/gif':
							$img = imagecreatefromgif($image);
							$new = imagecreatetruecolor($thumb_size, $thumb_size);
							imagecopyresampled($new, $img, 0, 0, $x, $y, $thumb_size, $thumb_size, $smallestSide,$smallestSide);
						break;
						default: die();
					}
					imagejpeg($new, $thumb_dir.$images.'.'.$extension);
					imagedestroy($new);
				}
				
				?>
                <div class="grid_list_details">
                    <a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $image); ?>')" class="file_managericon"><img src="<?php echo $thumb_image; ?>" alt="" title=""></a>
    
                    <div class="grid_view_edit_detele">
                    	<a href="<?php echo $image; ?>" title="Download" download><i class="fa fa-download" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" title="Preview"><i class="fa fa-eye" onClick="view_image('<?php echo $image; ?>')" title="View" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" title="Rename" onclick="change_folder_name('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $images; ?>', '<?php echo '.'.$extension; ?>')" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="dele_icon_colr" href="javascript:void(0)" title="Erase" onclick="erase_folder('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $images; ?>', '<?php echo '.'.$extension; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                    <a href="javascript:void(0)" class="file_name"><?php echo $images; ?></a>
                </div>
				<?php
			}
			
			$folder_image = array_merge($folderlists, $imagelists); 
			
			foreach($fileList as $filename)
			{
				if(!in_array($filename, $folder_image))
				{
					$filetype = @mime_content_type($filename);
					$extension = pathinfo($filename, PATHINFO_EXTENSION);
					$filenames = str_replace(array($dir, '.'.$extension), array('', ''), $filename);
					?>
					<div class="grid_list_details">
					
						<?php
						if(strstr($filetype, "video/"))
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_video_icon"><i class="fa fa-file-video-o" aria-hidden="true"></i></a>
							<?php
						}
						elseif(strstr($filetype, "audio/"))
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_volume_icon"><i class="fa fa-volume-up" aria-hidden="true"></i></a>
							<?php
						}
						elseif($extension == 'pdf')
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_pdf_icon"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
							<?php
						}
						elseif($extension == 'html')
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_code_icon"><i class="fa fa-code" aria-hidden="true"></i></a>
							<?php
						}
						elseif($extension == 'txt')
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_text_icon"><i class="fa fa-file-text" aria-hidden="true"></i></a>
							<?php
						}
						elseif($extension == 'zip')
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_archive_icon"><i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
							<?php
						}
						elseif(!is_dir($filename) && !strstr($filetype, "image/"))
						{
							?>
							<a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="file_icon"><i class="fa fa-file" aria-hidden="true"></i></a>
							<?php
						}
						?>
						<div class="grid_view_edit_detele">
							<a href="<?php echo $filename; ?>" title="Download" download><i class="fa fa-download" aria-hidden="true"></i></a>
							<a href="javascript:void(0)" title="Rename" onclick="change_folder_name('<?php echo $dir; ?>', '<?php echo $dir; ?>', '<?php echo $filenames; ?>', '<?php echo '.'.$extension; ?>')" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
							<a class="dele_icon_colr" href="javascript:void(0)" title="Erase" onclick="erase_folder('<?php echo $dir; ?>', '<?php echo $dir; ?>', '<?php echo $filenames; ?>', '<?php echo '.'.$extension; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						</div>
						<a href="javascript:void(0)" class="file_name"><?php echo $filenames; ?></a>
					</div>
					<?php
				}
			}
			?>
            
		</div>

		<div id="list_view" class="list_view comm_list_grid" style="display:none">
        
			<table cellpadding="0" cellspacing="0">
				
                <tr class="list_view_head_bg">
					<th>File Nmae</th>
					<th>Type</th>
					<th>Size</th>
					<th>Date</th>
					<th>Options</th>
				</tr>

				<?php
                // Folders
                foreach($folderlists as $folder)
                {
                    $created_date = date("m-d-Y", filemtime($folder));
                    $folder = str_replace($dir, '', $folder);
                    ?>
                    <tr>
                        <td><a href="index.php?fldr=<?php echo $getfolder.$folder; ?>" class="list_file_name"><i class="fa fa-folder" aria-hidden="true"></i><?php echo $folder; ?></a></td>
                        <td>dir</td>
                        <td></td>
                        <td><?php echo $created_date; ?></td>
                        <td>
                            <div class="edit_delete_icon">
                                <a href="javascript:void(0)" title="Rename" class="list_edit" onclick="change_folder_name('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $folder; ?>', '')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" title="Erase" class="list_delete" onclick="erase_folder('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $folder; ?>', '')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
				
				// Images
				foreach($imagelists as $image)
				{
					$extension = pathinfo($image, PATHINFO_EXTENSION);
					$images = str_replace(array($dir, '.'.$extension), array('', ''), $image);
					$thumb_image = str_replace($dir, $thumb_dir, $image);
					$size = filesize($image);
					$created_date = date("m-d-Y", filemtime($image));
					?>
                    <tr>
                        <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $image); ?>')" class="list_image_name"><i class="fa fa-picture-o" aria-hidden="true"></i><!--<img src="<?php echo $thumb_image; ?>" alt="" title="">--> <?php echo $images; ?></a></td>
                        <td><?php echo $extension; ?></td>
                        <td><?php echo $size; ?></td>
                        <td><?php echo $created_date; ?></td>
                        <td>
                            <div class="edit_delete_icon">
                            	<a class="list_edit" href="<?php echo $image; ?>" title="Download" download><i class="fa fa-download" aria-hidden="true"></i></a>
                                <a class="list_edit" href="javascript:void(0)" title="Preview"><i class="fa fa-eye" onClick="view_image('<?php echo $image; ?>')" title="View" aria-hidden="true"></i></a>
								<a class="list_edit" href="javascript:void(0)" title="Rename" onclick="change_folder_name('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $images; ?>', '<?php echo '.'.$extension; ?>')" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a class="list_delete" href="javascript:void(0)" title="Erase" onclick="erase_folder('<?php echo $dir; ?>', '<?php echo $thumb_dir; ?>', '<?php echo $images; ?>', '<?php echo '.'.$extension; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
					<?php
				}
				
				$folder_image = array_merge($folderlists, $imagelists); 
			
				foreach($fileList as $filename)
				{
					if(!in_array($filename, $folder_image))
					{
						$filetype = @mime_content_type($filename);
						$extension = pathinfo($filename, PATHINFO_EXTENSION);
						$filenames = str_replace(array($dir, '.'.$extension), array('', ''), $filename);
						$size = filesize($filename);
						$created_date = date("m-d-Y", filemtime($filename));
						?>
						<tr>
						
							<?php
							if(strstr($filetype, "video/"))
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_image_name"><i class="fa fa-file-video-o" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							elseif(strstr($filetype, "audio/"))
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_image_name"><i class="fa fa-volume-up" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							elseif($extension == 'pdf')
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_image_name"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							elseif($extension == 'html')
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_image_name"><i class="fa fa-code" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							elseif($extension == 'txt')
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_image_name"><i class="fa fa-file-text" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							elseif($extension == 'zip')
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_image_name"><i class="fa fa-file-archive-o" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							elseif(!is_dir($filename) && !strstr($filetype, "image/"))
							{
								?>
                                <td><a href="javascript:void(0)" onclick="getvalue('<?php echo $field_id; ?>', '<?php echo str_replace('..', '', $filename); ?>')" class="list_file_name"><i class="fa fa-file" aria-hidden="true"></i> <?php echo $filenames; ?></a></td>
								<?php
							}
							?>
                            <td><?php echo $extension; ?></td>
                            <td><?php echo $size; ?></td>
                            <td><?php echo $created_date; ?></td>
                            <td>
                                <div class="edit_delete_icon">
                                    <a class="list_edit" href="<?php echo $filename; ?>" title="Download" download><i class="fa fa-download" aria-hidden="true"></i></a>
									<a class="list_edit" href="javascript:void(0)" title="Rename" onclick="change_folder_name('<?php echo $dir; ?>', '<?php echo $dir; ?>', '<?php echo $filenames; ?>', '<?php echo '.'.$extension; ?>')" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<a class="list_delete" href="javascript:void(0)" title="Erase" onclick="erase_folder('<?php echo $dir; ?>', '<?php echo $dir; ?>', '<?php echo $filenames; ?>', '<?php echo '.'.$extension; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </div>
                            </td>
						</tr>
						<?php
					}
				}
                ?>
                
			</table>
		</div>
            
  		
	</div>
</div>
<?php include('include/footer.php'); ?>