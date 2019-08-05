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
    )
  );
  
  echo meta($meta_array);
  
  if (isset($title) && $title != "") :
    $admin_title = $title;
  else :
    $admin_title = 'Administrator';
  endif;
?>
<title><?php echo $admin_title;?></title>
