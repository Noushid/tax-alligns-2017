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

$route['ad-login'] = 'Auth/login';
$route['logout'] = 'Auth/logout';

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
$route['send-comment'] = 'Home/send_comment';

/*------- session routes ----------*/

$route['login'] = 'user/login';
$route['send'] = 'Home/compose';
$route['delivered/(:num)'] = 'Home/delivered/$1';

/*_______ public route End _______*/

/*shammas designing testing routes*/
$route['practice'] = 'Home/practice';
/*shammas designing testing routes*/

/*_______ admin route start _______*/

$route['dashboard'] = 'Dashboard';
$route['dashboard/edit-profile'] = 'Dashboard/edit_user';
$route['dashboard/edit-profile/submit/(:num)'] = 'Dashboard/edit_user/$1';

$route['dashboard/testimonial'] = 'Dashboard/testimonial';
$route['dashboard/testimonial/upload'] = 'Testimonial_Controller/upload';
$route['dashboard/testimonial/get']['get'] = 'Testimonial_Controller/get_all';
$route['dashboard/testimonial/add']['post'] = 'Testimonial_Controller/store';
$route['dashboard/testimonial/edit/(:num)']['post'] = 'Testimonial_Controller/update/$1';
$route['dashboard/testimonial/delete-image/(:num)']['delete'] = 'Testimonial_Controller/delete_image/$1';
$route['dashboard/testimonial/delete/(:num)']['delete'] = 'Testimonial_Controller/delete/$1';


$route['dashboard/blog'] = 'Dashboard/blog';
$route['dashboard/blog/upload'] = 'Blog_Controller/upload';
$route['dashboard/blog/get']['get'] = 'Blog_Controller/get_all';
$route['dashboard/blog/add']['post'] = 'Blog_Controller/store';
$route['dashboard/blog/edit/(:num)']['post'] = 'Blog_Controller/update/$1';
$route['dashboard/blog/delete-image/(:num)']['delete'] = 'Blog_Controller/delete_image/$1';
$route['dashboard/blog/delete/(:num)']['delete'] = 'Blog_Controller/delete/$1';


$route['dashboard/document'] = 'Dashboard/document';
$route['dashboard/document/upload'] = 'Document_Controller/upload';
$route['dashboard/document/get']['get'] = 'Document_Controller/get_all';
$route['dashboard/document/add']['post'] = 'Document_Controller/store';
$route['dashboard/document/edit/(:num)']['post'] = 'Document_Controller/update/$1';
$route['dashboard/document/delete-image/(:num)']['delete'] = 'Document_Controller/delete_image/$1';
$route['dashboard/document/delete/(:num)']['delete'] = 'Document_Controller/delete/$1';


$route['dashboard/user'] = 'Dashboard/users';
$route['dashboard/user/get-all']['get'] = 'User_Controller';
$route['dashboard/user/get']['get'] = 'User_Controller/get_all';
$route['dashboard/user/activate/(:num)']['post'] = 'User_Controller/activate/$1';
$route['dashboard/user/de-activate/(:num)']['post'] = 'User_Controller/de_activate/$1';

$route['dashboard/user/add']['post'] = 'User_Controller/store';
$route['dashboard/user/delete/(:num)']['delete'] = 'User_Controller/delete/$1';

$route['dashboard/messages'] = 'Dashboard/message';
$route['dashboard/message/get/(:num)']['get'] = 'Message_Controller/get/$1';
$route['dashboard/message/upload']['post'] = 'Message_Controller/upload';
$route['dashboard/message/send/(:num)']['post'] = 'Message_Controller/send/$1';
//$route['dashboard/message/viewed/(:num)'] = 'Message_Controller/viewed/$1';
$route['dashboard/message/sent-item/(:num)']['get'] = 'Message_Controller/get_where/$1/sent';
$route['dashboard/message/inbox/(:num)']['get'] = 'Message_Controller/get_where/$1/received';
$route['dashboard/message/delivered/(:num)']['put'] = 'Message_Controller/delivered/$1';

/*_______ admin route end _______*/


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
