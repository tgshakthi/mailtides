<?php
/**
 * Theme
 *
 * @category class
 * @package  Theme
 * @author   Athi
 * Created at:  12-May-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Theme extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Theme_model');
		$this->load->module('admin_header');
    }

    // Get Theme
    function index()
    {
		// Website 
		$website_id	= $this->admin_header->website_id();
		
		// Get Theme
		$data['themes']	= $this->Theme_model->get_theme($website_id);
		
		$data['heading']	= 'Theme';
		$data['title']	= 'Theme | Administrator';
		$this->load->view('template/meta_head');
		$this->load->view('theme_header');
		$this->admin_header->index();
		$this->load->view('theme', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Active Theme
	function active_theme($id)
	{
		// Get Website Id From Admin Header
		$website_id	= $this->admin_header->website_id();
		
		$this->Theme_model->active_theme($id, $website_id);
		$this->session->set_flashdata('success', 'Successfully Activated!');
		redirect('theme');
	}
	
	// Choose Theme
    function choose_theme()
    {
		$data['heading']	= 'Choose Theme';
		$data['title']	= 'Choose Theme | Administrator';
		$this->load->view('template/meta_head');
		$this->load->view('theme_header');
		$this->admin_header->index();
		$this->load->view('choose_theme', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Install Theme
	function install()
	{
		$filename = $_FILES['fupload']['name'];
		$source   = $_FILES['fupload']['tmp_name'];
		$type     = $_FILES['fupload']['type'];

		$name = explode('.', $filename);
		
		// Create Temp Folder
		if (!is_dir('./Temp'))
		{
			mkdir('./Temp');
		}
		
		$theme_name = $name[0];
		$target      = './Temp/'.$theme_name.'/';
		
		//Get Installed Theme
		$themes = $this->Theme_model->check_theme(ucwords($theme_name));
		if (empty($themes))
		{
			$accepted_types = array ('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/s-compressed');

			foreach ($accepted_types as $mime_type)
			{
				if($mime_type == $type)
				{
					$okay = true;
					break;
				}
			}

			// Its's Zip Or Not
			$okay = strtolower($name[1]) == 'zip' ? true: false;
			if (!$okay)
			{
				$this->session->set_flashdata('error', 'Please choose a zip file!');
				return false;
			}

			mkdir ($target);
			$saved_file_location = $target . $filename;
		
			// Upload and Extract Zip File
			if (move_uploaded_file ($source, $saved_file_location))
			{
				$zip = new ZipArchive();
				$x   = $zip->open($saved_file_location);
				if($x === true)
				{
					$zip->extractTo($target);
					$zip->close();

					unlink ($saved_file_location);
				}
				else
				{
					$this->session->set_flashdata('error', 'There was a problem. Please try again!');
					return false;
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'There was a problem. Please try again!');
				return false;
			}
		
			// Scan Theme Folder in Temp
			$scan = scandir($target);
			for ($i = 0; $i<count ($scan); $i++)
			{
				if ($scan[$i] != '.' && $scan[$i] != '..')
				{
					$theme = "theme";
					
					if ($scan[$i] == "application")
					{
						$module = "modules";
						
						// Scan Modules Folder in Temp
						$scan_app_module = scandir ($target.$scan[$i].'/'.$module.'/');
						for ($app = 0; $app<count ($scan_app_module); $app++)
						{
							if ($scan_app_module[$app] != '.' && $scan_app_module[$app] != '..')
							{
								$inc = "inc";
								
								if ($scan_app_module[$app] == "header")
								{
									// Scan Header Folder in Temp
									$scan_header = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/');
									for ($header = 0; $header<count ($scan_header); $header++)
									{
										if ($scan_header[$header] != '.' && $scan_header[$header] != '..')
										{
											if ($scan_header[$header] == "controllers")
											{
												// Create Controllers Folder
												if(!is_dir('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header]))
												{
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header]);
												}
												
												$controllers_files = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header]);
												
												// Get Controllers Files 
												foreach ($controllers_files as $controllers_file)
												{
													if ($controllers_file != '.' && $controllers_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$controllers_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$controllers_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
											
											if ($scan_header[$header] == "models")
											{
												// Create Models Folder
												if(!is_dir('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header]))
												{
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header]);
												}
												
												$models_files = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header]);
												
												// Get Models Files 
												foreach ($models_files as $models_file)
												{
													if ($models_file != '.' && $models_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$models_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$models_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
											
											if ($scan_header[$header] == "views")
											{
												// Create Theme Folder
												if(!is_dir('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$theme.'/'.$theme_name))
												{
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$theme.'/'.$theme_name);
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$theme.'/'.$theme_name.'/'.$inc);
												}
												
												$views_files = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$theme.'/'.$inc);
												
												// Get Views Files 
												foreach ($views_files as $views_file)
												{
													if ($views_file != '.' && $views_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$theme.'/'.$theme_name.'/'.$inc.'/'.$views_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_header[$header].'/'.$theme.'/'.$inc.'/'.$views_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
										}
									}
								}
								
								if ($scan_app_module[$app] == "footer")
								{
									// Scan Footer Folder in Temp
									$scan_footer = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/');
									for ($footer = 0; $footer<count ($scan_footer); $footer++)
									{
										if ($scan_footer[$footer] != '.' && $scan_footer[$footer] != '..')
										{
											if ($scan_footer[$footer] == "controllers")
											{
												// Create Controllers Folder
												if(!is_dir('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer]))
												{
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer]);
												}
												
												$controllers_files = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer]);
												
												// Get Controllers Files 
												foreach ($controllers_files as $controllers_file)
												{
													if ($controllers_file != '.' && $controllers_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$controllers_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$controllers_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
											
											if ($scan_footer[$footer] == "models")
											{
												// Create Models Folder
												if(!is_dir('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer]))
												{
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer]);
												}
												
												$models_files = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer]);
												
												// Get Models Files 
												foreach ($models_files as $models_file)
												{
													if ($models_file != '.' && $models_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$models_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$models_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
											
											if ($scan_footer[$footer] == "views")
											{
												// Create Theme Folder
												if(!is_dir('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$theme.'/'.$theme_name))
												{
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$theme.'/'.$theme_name);
													mkdir ('../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$theme.'/'.$theme_name.'/'.$inc);
												}
												
												$views_files = scandir ($target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$theme.'/'.$inc);
												
												// Get Views Files 
												foreach ($views_files as $views_file)
												{
													if ($views_file != '.' && $views_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$theme.'/'.$theme_name.'/'.$inc.'/'.$views_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$module.'/'.$scan_app_module[$app].'/'.$scan_footer[$footer].'/'.$theme.'/'.$inc.'/'.$views_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if ($scan[$i] == "assets")
					{
						// Scan Assets Folder in Temp
						$scan_assets = scandir ($target.$scan[$i].'/');
						for ($as = 0; $as<count ($scan_assets); $as++)
						{
							if ($scan_assets[$as] != '.' && $scan_assets[$as] != '..')
							{
								if ($scan_assets[$as] == $theme)
								{
									if(!is_dir('../'.$scan[$i].'/'.$theme.'/'.$theme_name))
									{
										mkdir ('../'.$scan[$i].'/'.$theme.'/'.$theme_name);
									}
									
									// Scan Theme Folder in Temp
									$scan_theme = scandir ($target.$scan[$i].'/'.$theme.'/');
									for ($ass = 0; $ass<count ($scan_theme); $ass++)
									{
										if ($scan_theme[$ass] != '.' && $scan_theme[$ass] != '..')
										{
											if ($scan_theme[$ass] == "css")
											{
												$css = "css";
												
												if(!is_dir('../'.$scan[$i].'/'.$theme.'/'.$theme_name.'/'.$css))
												{
													mkdir ('../'.$scan[$i].'/'.$theme.'/'.$theme_name.'/'.$css);
												}
												
												$css_files = scandir ($target.$scan[$i].'/'.$theme.'/'.$css);
												
												// Get Css Files
												foreach ($css_files as $css_file)
												{
													if ($css_file != '.' && $css_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$theme.'/'.$theme_name.'/'.$css.'/'.$css_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$theme.'/'.$css.'/'.$css_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
											
											if ($scan_theme[$ass] == "js")
											{
												$js = "js";
												
												if(!is_dir('../'.$scan[$i].'/'.$theme.'/'.$theme_name.'/'.$js))
												{
													mkdir ('../'.$scan[$i].'/'.$theme.'/'.$theme_name.'/'.$js);
												}
												
												$js_files = scandir ($target.$scan[$i].'/'.$theme.'/'.$js);
												
												// Get Js Files
												foreach ($js_files as $js_file)
												{
													if ($js_file != '.' && $js_file != '..')
													{
														$file_to_go = '../'.$scan[$i].'/'.$theme.'/'.$theme_name.'/'.$js.'/'.$js_file;
														if (!file_exists ($file_to_go))
														{
															$file_name = $target.$scan[$i].'/'.$theme.'/'.$js.'/'.$js_file;
															copy ($file_name, $file_to_go);
														}
													}
												}
											}
										}
									}
								}
								
								if ($scan_assets[$as] == "images")
								{
									if(!is_dir('../'.$scan[$i].'/'.$scan_assets[$as].'/'.$theme.'/'.$theme_name))
									{
										mkdir ('../'.$scan[$i].'/'.$scan_assets[$as].'/'.$theme.'/'.$theme_name);
									}
									
									$image_files = scandir ($target.$scan[$i].'/'.$scan_assets[$as].'/'.$theme);
												
									// Get Images
									foreach ($image_files as $image_file)
									{
										if ($image_file != '.' && $image_file != '..')
										{
											$file_to_go = '../'.$scan[$i].'/'.$scan_assets[$as].'/'.$theme.'/'.$theme_name.'/'.$image_file;
											if (!file_exists ($file_to_go))
											{
												$file_name = $target.$scan[$i].'/'.$scan_assets[$as].'/'.$theme.'/'.$image_file;
												copy ($file_name, $file_to_go);
											}
										}
									}
								}
							}
						}
					}
				}
			}
		
			//Remove Extraxt Folder
			$this->remove_extract_folder("Temp/".$theme_name);
			
			//Insert Theme
			$this->Theme_model->insert_theme(ucwords($theme_name), 'assets/images/theme/'.$theme_name.'/'.$theme_name.'.jpg');
			
			//Success Message
			$this->session->set_flashdata('success', 'Successfully Installed '.ucwords($theme_name).' Theme!');
		}
		else
		{
			//Error Message
			$this->session->set_flashdata('error', ucwords($theme_name).' Theme is Already Installed!');
		}
	}
	
	// Remove Extract Folder in Tenmp Folder
	function remove_extract_folder($path)
	{
		$root = $path;
		$iter = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST,
			RecursiveIteratorIterator::CATCH_GET_CHILD
		);
		$paths = array ($root);
		
		foreach ($iter as $path => $dir) {
				$paths[] = $path;
		}

		for ($d = 0; $d<count ($paths); $d++)
		{

			if (is_dir ($paths[$d]))
			{
				 if(count (glob ($paths[$d]."/*")) === 0 )
				 {
					 rmdir ($paths[$d]);
					 $d = 0;
				 }
			}
			elseif (file_exists ($paths[$d]))
			{
				unlink ($paths[$d]);
				$d = 0;
			}
		}
		rmdir ($root);
	}
}