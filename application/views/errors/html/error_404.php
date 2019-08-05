<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$CI =& get_instance();
	if( ! isset($CI))
	{
			$CI = new CI_Controller();
	}
	$CI->load->helper('url');
	$CI->load->helper('html');
?>
<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>404 Page Not Found</title>
		<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
		<style type="text/css">
			body {
				background: rgba(0, 0, 0, 0) url(assets/images/form-bg.jpg) fixed 0 0;
				background-repeat: no-repeat;
				height: 100%;
				margin: 0;
				padding: 0;
				position: fixed;
				top: 0;
				width: 100%;
				background-size: 100% 100%;
			}
		</style>
	</head>

	<body>

		<section class="section">

			<div class="container">
				<?php echo heading($heading, 1, array(
					'class' => 'center-align'
				));?>

				<div class="flow-text center-align">
					<?php echo $message;?>
				</div>
				<div class="center-align">
					<a href="<?php echo base_url();?>" class="btn">Go to HomePage</a>
				</div>

			</div>

		</section>

	</body>
	</html>

	<script>
		window.onload = function () {
			let ref = window.location.href;
			
			let xhr = new XMLHttpRequest();

			xhr.open('POST', '<?php echo base_url();?>' + 'page/get_error_page_path');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send(encodeURI('url=' + ref));

		}
	</script>