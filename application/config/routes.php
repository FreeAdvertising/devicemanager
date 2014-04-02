<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';
$route["device/(:any)/apps"] = "device/apps/$1";
$route["device/(:any)/history"] = "device/history/$1";
$route["device/(:any)/assoc_app_to_device"] = "device/assoc_app_to_device/$1";
$route["device/(:any)/add_application"] = "device/add_application/$1";
$route["device/(:any)/check_in"] = "device/check_in/$1";
$route["device/(:any)/check_out"] = "device/check_out/$1";
$route["device/(:any)/cancel_reservation"] = "device/cancel_reservation/$1";
$route["device/(:any)/reserve"] = "device/reserve/$1";
$route["device/(:any)/edit"] = "device/edit/$1";
$route["device/(:any)"] = "device/index/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */