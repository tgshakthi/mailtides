<?php
if(isset($_FILES["upload_file1"]["name"]))
{
	$file_name = (isset($_POST["filename"]) && $_POST["filename"] != '') ? $_POST["filename"]: array();
	for($i=0;$i<count($_FILES["upload_file1"]["name"]);$i++)
	{
 		$uploaddir = $_POST['upload_folder'];
		$uploadfile = basename($_FILES["upload_file1"]["name"][$i]);
		if(in_array($uploadfile, $file_name))
		{
			move_uploaded_file($_FILES["upload_file1"]["tmp_name"][$i], $uploaddir.$uploadfile);
			
			$file = $uploaddir.$uploadfile;
			$pathToSave   = $_POST['thumb_folder'];
			
			$thumb_size  = 100;
			$what = getimagesize($file);
			list($width, $height) = getimagesize($file);
			
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
					$img = imagecreatefrompng($file);
					$new = imagecreatetruecolor($thumb_size, $thumb_size);
					imagecopyresampled($new, $img, 0, 0, $x, $y, $thumb_size, $thumb_size, $smallestSide, $smallestSide);
				break;
				case 'image/jpeg':
					$img = imagecreatefromjpeg($file);
					$new = imagecreatetruecolor($thumb_size, $thumb_size);
					imagecopyresampled($new, $img, 0, 0, $x, $y, $thumb_size, $thumb_size, $smallestSide, $smallestSide);
				break; 
				case 'image/gif':
					$img = imagecreatefromgif($file);
					$new = imagecreatetruecolor($thumb_size, $thumb_size);
					imagecopyresampled($new, $img, 0, 0, $x, $y, $thumb_size, $thumb_size, $smallestSide,$smallestSide);
				break;
				default: die();
			}
			imagejpeg($new, $pathToSave.$uploadfile);
			imagedestroy($new);
		}
	}
}

if(isset($_POST['old_folder_name']))
{
	$folder_path = $_POST['folder_path'];
	$thumb_path = $_POST['thumb_path'];
	$old_folder_name = $_POST['old_folder_name'];
	$new_folder_name = $_POST['new_folder_name'];
	$extension = $_POST['extension'];
	rename($folder_path.$old_folder_name.$extension, $folder_path.$new_folder_name.$extension);
	rename($thumb_path.$old_folder_name.$extension, $thumb_path.$new_folder_name.$extension);
}

if(isset($_POST['confirm_delete_path']))
{
	$confirm_delete_path = $_POST['confirm_delete_path'];
	$confirm_delete_thumb_path = $_POST['confirm_delete_thumb_path'];
	$confirm_delete_folder = $_POST['confirm_delete_folder'];
	$confirm_delete_extention = $_POST['confirm_delete_extention'];
	
	if($confirm_delete_extention == '')
	{
		$root = $confirm_delete_path.$confirm_delete_folder;
		$iter = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST,
			RecursiveIteratorIterator::CATCH_GET_CHILD
		);
		$paths = array($root);
		foreach ($iter as $path => $dir) {
				$paths[] = $path;
		}
	
		for ($d = 0; $d<count($paths); $d++)
		{
	
			if(is_dir($paths[$d]))
			{
				 if(count(glob($paths[$d]."/*")) === 0 )
				 {
					 rmdir($paths[$d]);
					 $d = 0;
				 }
			}
			elseif(file_exists($paths[$d]))
			{
				unlink($paths[$d]);
				$d = 0;
			}
		}
		rmdir($root);
		unlink($confirm_delete_thumb_path.$confirm_delete_folder.$confirm_delete_extention);
	}
	else
	{
		unlink($confirm_delete_path.$confirm_delete_folder.$confirm_delete_extention);
		unlink($confirm_delete_thumb_path.$confirm_delete_folder.$confirm_delete_extention);
	}
}

if(isset($_POST['create_folder_path']))
{
	$folder_path = $_POST['create_folder_path'];
	$create_folder_name = $_POST['create_folder_name'];
	mkdir($folder_path.$create_folder_name);
}
?>