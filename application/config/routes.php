<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'page';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['setup.html'] = 'setup';
$route['index.html'] = 'page';
$route['(:any)'] = "page";
$route['blog/(:any)'] = "blog/subpage";
$route['event/(:any)'] = "event/subpage";
$route['testimonial/(:any)'] = "testimonial/subpage";

?>