<?php
	/**
	 * Auto load css files
	 */
	foreach (glob('assets/theme/'.$theme.'/css/*.css') as $filename)
	{
		echo link_tag($filename);
	}

	/**
	 * Auto load Dependency css files
	 */
	foreach (glob('assets/theme/'.$theme.'/css/dependency/*.css') as $filename)
	{
		echo link_tag($filename);
	}

	/**
	 * Auto load Components Css files
	 */
	foreach (glob('assets/theme/'.$theme.'/css/components/*.css') as $filename)
	{
		echo link_tag($filename);
	}
?>
