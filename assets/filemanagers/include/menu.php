<?php
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].'';
$field_id = (isset($_GET['field_id']) && $_GET['field_id'] != '') ? $_GET['field_id']: '';
			
$getfolder = (isset($_GET['fldr']) && $_GET['fldr'] != '') ? $_GET['fldr'].'/': '';
$dir = '../images/'.$getfolder;
$thumb_dir = '../thumbs/';
?>

<div class="filemanager_header">
	<div class="file_head_left">
    	<?php if(!isset($_GET['type']) || $_GET['type'] != 'upload') { ?>
		<?php /*?><div class="file_dropdown_list">
			<a href="javascript:void(0)" class="file_icon_head"><i class="fa fa-angle-double-down" aria-hidden="true"></i></a>
			<ul class="mobile_dropdown_head">
				
                <li><a href="javascript:void(0)" onclick="create_folder('<?php echo $dir; ?>')"><span class="fa fa-folder-o" aria-hidden="true"></span>Create Folder</a></li>
				<li><a href="<?php echo (isset($_GET['fldr']) && $_GET['fldr'] != '') ? 'upload.php?field_id='.$field_id.'&type=upload&fldr='.$_GET['fldr'].'/': 'upload.php?field_id='.$field_id.'&type=upload'; ?>"><span class="fa fa-upload" aria-hidden="true"></span>upload</a></li>

			</ul>
		</div><?php */?>
        <?php } ?>

		<div class="angle_left">
			<a href="index.php?field_id=<?php echo $field_id; ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
            <a class="mobile_heid" onclick="goBack()" href="javascript:void(0)"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <a class="mobile_heid" onclick="goForward()" href="javascript:void(0)"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
            <?php if(!isset($_GET['type']) || $_GET['type'] != 'upload') { ?>
			<a class="mobile_heid" href="javascript:void(0)" onclick="create_folder('<?php echo $dir; ?>')">+ <i class="fa fa-folder" aria-hidden="true"></i></a>
			<a class="mobile_heid" href="<?php echo (isset($_GET['fldr']) && $_GET['fldr'] != '') ? 'upload.php?field_id='.$field_id.'&type=upload&fldr='.$_GET['fldr'].'/': 'upload.php?field_id='.$field_id.'&type=upload'; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
            <?php } ?>
		</div>

		<a href="javascript:void(0)" class="file_manager_refresh" onclick="refresh()"><i class="fa fa-refresh" aria-hidden="true"></i></a>

		
	</div>

	<div class="file_right_">
    	<?php if(!isset($_GET['type']) || $_GET['type'] != 'upload') { ?>
		<div class="file_menager_search">
			<input type="text" id="search_name" placeholder="Text Filter" onkeyup="search_name()" value="">
		</div>
        

		<div class="file_grid_view">
			<a href="javascript:void(0)" onclick="grid_view()" class="grid_v"><i class="fa fa-th" aria-hidden="true"></i></a>
			<a href="javascript:void(0)" onclick="list_view()" class="grid_v"><i class="fa fa-list" aria-hidden="true"></i></a>
		</div>
        <?php } ?>
	</div>

	<br class="spacer">

	<div class="home_total_filecount">
		<a href="#"></a>
	</div>
</div>
<input type="hidden" id="field_id" value="<?php echo $field_id;?>" />
<input type="hidden" id="base_url" value="<?php echo $base_url;?>" />

<div class="file_path_link">
	<?php
    $folder_dirs = (isset($_GET['fldr']) && $_GET['fldr'] != '') ? explode('/', $_GET['fldr']): array();
    $path = '';
    foreach($folder_dirs as $folder_dir)
    {
        $path = ($path == '') ? $folder_dir: $path.'/'.$folder_dir;
        ?>
        <a href="index.php?fldr=<?php echo $path; ?>"><?php echo $folder_dir; ?></a>
        <?php
    }
    ?>
</div>