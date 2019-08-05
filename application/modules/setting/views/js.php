<?php
	/**
	 * Auto load js files
	 */
	foreach (glob('assets/theme/'.$theme.'/js/*.js') as $filename)
	{
		echo '<script src="'.base_url().$filename.'"></script>';
	}

	/**
	 * Auto load Dependency js files
	 */
	foreach (glob('assets/theme/'.$theme.'/js/dependency/*.js') as $filename)
	{
		echo '<script src="'.base_url().$filename.'"></script>';
	}

	/**
	 * Auto load Components js files
	 */
	foreach (glob('assets/theme/'.$theme.'/js/components/*.js') as $filename)
	{
		echo '<script src="'.base_url().$filename.'"></script>';
	}
?>
