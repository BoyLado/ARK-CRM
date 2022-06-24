<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'NavigationController';
$route['404_override'] = 'NavigationController/page404';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'NavigationController/login';
$route['login/(:any)'] = 'NavigationController/loginWithAuth/$1';
$route['forgot-password'] = 'NavigationController/forgotPassword';
$route['change-password/(:any)'] = 'NavigationController/changePassword/$1';
$route['customers'] = 'NavigationController/index';

$route['submit-sample-email'] = 'TestController/sampleEmail';

