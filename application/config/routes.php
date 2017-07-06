<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';

/*_______ public route start _______*/
$route['home'] = 'Home/index';
$route['about'] = 'Home/about';
$route['services'] = 'Home/services';

$route['login'] = 'Home/login';
$route['login/verify'] = 'Dashboard/verify';
$route['logout'] = 'Dashboard/logout';

$route['GST'] = 'Home/gst';
$route['WhatIsGST'] = 'Home/whatisgst';
$route['GSTfiling'] = 'Home/gstfiling';
$route['GSTaccounting'] = 'Home/gstaccounting';
$route['GSTinvoice'] = 'Home/gstinvoice';

$route['ITreturns'] = 'Home/returns';
$route['TDS'] = 'Home/tds';

$route['blog'] = 'Home/blog';
$route['blog/(:num)'] = 'Home/blog/$1';
$route['gst/(:num)'] = 'Home/blogView/$1';
$route['contact'] = 'Home/contact';
$route['send-message'] = 'Home/send_message';
/*_______ public route End _______*/

/*_______ admin route start _______*/

$route['admin'] = 'Dashboard';

$route['admin/testimonial'] = 'Dashboard/testimonial';
$route['admin/testimonial/upload'] = 'Testimonial_Controller/upload';
$route['admin/testimonial/get']['get'] = 'Testimonial_Controller/get_all';
$route['admin/testimonial/add']['post'] = 'Testimonial_Controller/store';
$route['admin/testimonial/edit/(:num)']['post'] = 'Testimonial_Controller/update/$1';
$route['admin/testimonial/delete-image/(:num)']['delete'] = 'Testimonial_Controller/delete_image/$1';
$route['admin/testimonial/delete/(:num)']['delete'] = 'Testimonial_Controller/delete/$1';


$route['admin/blog'] = 'Dashboard/blog';
$route['admin/blog/upload'] = 'Blog_Controller/upload';
$route['admin/blog/get']['get'] = 'Blog_Controller/get_all';
$route['admin/blog/add']['post'] = 'Blog_Controller/store';
$route['admin/blog/edit/(:num)']['post'] = 'Blog_Controller/update/$1';
$route['admin/blog/delete-image/(:num)']['delete'] = 'Blog_Controller/delete_image/$1';
$route['admin/blog/delete/(:num)']['delete'] = 'Blog_Controller/delete/$1';


$route['admin/document'] = 'Dashboard/document';
$route['admin/document/upload'] = 'Document_Controller/upload';
$route['admin/document/get']['get'] = 'Document_Controller/get_all';
$route['admin/document/add']['post'] = 'Document_Controller/store';
$route['admin/document/edit/(:num)']['post'] = 'Document_Controller/update/$1';
$route['admin/document/delete-image/(:num)']['delete'] = 'Document_Controller/delete_image/$1';
$route['admin/document/delete/(:num)']['delete'] = 'Document_Controller/delete/$1';

/*_______ admin route end _______*/


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
