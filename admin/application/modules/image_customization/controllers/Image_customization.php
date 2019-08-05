<?php
/**
 * Image Customization
 *
 * @category class
 * @package  Image Customization
 * @author   Athi
 * Created at:  26-Sep-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Image_customization extends MX_Controller
{
	function __construct()
	{
		$this->session_data = $this->session->userdata('logged_in');
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Image_customization_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	function index()
	{
		$website_id = $this->admin_header->website_id();
		$data['image_customizations'] = $this->Image_customization_model->get_image_html($website_id);
		//print_r($data['image_customizations']); die;
		$setting_datas = $this->Image_customization_model->get_image_customize_setting_details($website_id, 'image_customization');
		if(!empty($setting_datas))
		{
			$keys = json_decode($setting_datas[0]->key);
			$values = json_decode($setting_datas[0]->value);

			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['active_page'] = 1;
			$data['page_count'] = 1;
		}
		
		$data['upload_path'] = '../assets/custom_images/';
		$data['heading']	= 'Image Customization';
		$data['title']	= "Image customization | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('image_customization_header');
		//$this->admin_header->index();
		$this->load->view('view', $data);
		//$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function upload_image()
	{
		$upload_path = $_POST['upload_path'];
		$files= $_FILES;
		$cpt = count ($_FILES['images']['name']);

		for($i = 0; $i < $cpt; $i ++) {

			$_FILES['images']['name'] = $files['images']['name'][$i];
			$_FILES['images']['type'] = $files['images']['type'][$i];
			$_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
			$_FILES['images']['error'] = $files['images']['error'][$i];
			$_FILES['images']['size'] = $files['images']['size'][$i];
			
			$uploadfile = basename($_FILES['images']['name']);
			move_uploaded_file($_FILES['images']['tmp_name'], $upload_path.$uploadfile);
			
			$fileName = $_FILES['images']['name'];
			$images[] = $fileName;
		}
		echo json_encode($images);
	}
	
	function custom_image_upload()
	{
		$upload_path = '../assets/images/custom_images/';
		$pic_name = ($_POST['pic_name'] != '') ? $_POST['pic_name']: 'your_pic_name';
		$image_type = ($_POST['image_type'] != '') ? '.'.$_POST['image_type']: '.jpg';
		$data = $_POST['image_data'];
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		
		if(file_put_contents($upload_path.$pic_name.'_'.time().$image_type, $data))
		{
			echo "Your Image has Uploaded!";
		}
		else
		{
			echo "Oops!";
		}
	}
	
	function resizeImage($SrcImage, $DestImage, $iWidth, $iHeight, $MaxWidth, $MaxHeight)
	{
		$NewCanves = imagecreatetruecolor($MaxWidth, $MaxHeight);
		$NewImage = imagecreatefromjpeg($SrcImage);
	
		// Resize Image
		imagecopyresampled($NewCanves, $NewImage,0, 0, 0, 0, $MaxWidth, $MaxHeight, $iWidth, $iHeight);
		imagejpeg($NewCanves,$DestImage);
		imagedestroy($NewCanves);
	}
	
	function crop_image()
	{
		ob_start();
		$jpeg_quality = 90;
		if(!isset($_POST['x']) || !is_numeric($_POST['x'])) {
			die(0);
		}
		$src = $_POST['src'];
		$basename = basename($src);
		$extension = pathinfo($src, PATHINFO_EXTENSION);
		if(strpos($src, 'crop_images'))
		{
			$new_src = str_replace('crop_images/'.$basename, 'temp/'.$basename, $src);
		}
		else
		{
			$new_src = str_replace($basename, 'temp/'.$basename, $src);
		} 
		list($width, $height) = getimagesize($src);
		$time = time();
		
		$resize_width = $_POST['crop_image_width'];
		$resize_height = $_POST['crop_image_height'];
		$this->resizeImage($src, $new_src, $width, $height, $resize_width, $resize_height);
		$new_src = '../assets/custom_images/temp/'.$basename;
		$crop_image = '../assets/custom_images/crop_images/'.str_replace('.'.$extension, '_'.$time.'.'.$extension, $basename);
		
		$img_r = imagecreatefromjpeg($new_src);
		$dst_r = ImageCreateTrueColor($_POST['w'], $_POST['h']);
		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$_POST['w'],$_POST['h'],$_POST['w'],$_POST['h']);
		header('Content-type: image/jpeg');
		imagejpeg($dst_r, $crop_image, $jpeg_quality);
		unlink($new_src);
		echo $crop_image;
		exit;
	}
	
	function save_image_data()
	{
		$website_id = $this->admin_header->website_id();
		$this->Image_customization_model->insert_update_image_html($website_id);
		$this->Image_customization_model->insert_update_setting($website_id);
	}
}
?>
