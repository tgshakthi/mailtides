<?php
  echo doctype('html5');

  echo '<html lang="en"><head>';

  echo meta(array(
    'name' => 'charset',
    'content' => 'utf-8'
  ));

  $meta_array = array(
    array(
      'name'    => 'Content-type',
      'content' => 'text/html; charset=utf-8',
      'type'    => 'equiv'
    ),
    array(
      'name'    => 'X-UA-Compatible',
      'content' => 'IE=edge',
      'type'    => 'equiv'
    ),
    array(
      'name'    => 'viewport',
      'content' => 'width=device-width, initial-scale=1'
		),
		array(
			'name' => 'description',
			'content' => $meta_description
		),
		array(
			'name' => 'keywords',
			'content' => $meta_keyword
		),
		array(
			'name' => 'robots',
			'content' => 'no-cache'
		)
  );

  echo meta($meta_array);

  echo link_tag('assets/images/'.$website_folder.'/'.$favicon, 'shortcut icon', 'image/ico');

?>
<title><?php echo $meta_title; ?></title>
<?php
  // Google Anlaytics Code 
  echo $google_analytics;
?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:200i,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Fjalla+One&amp;subset=latin-ext" rel="stylesheet"> 

 <!-- Bliss-font fonts heading tag only use-->
 <link href="assets/font/thesansfont/thesansfont.css" rel="stylesheet">
 
<!--thesansfont fonts heading tag only use-->
 <link href="assets/font/Bliss-Regular/Bliss-font.css" rel="stylesheet">

<!--google fonts paragraph and button tag only use-->
<link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i,900" rel="stylesheet"> 
<!-- font Material icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- font awesome icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
