<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'NavigationController';
$route['404_override'] = 'NavigationController/page404';
$route['translate_uri_dashes'] = FALSE;

// ============================= Navigations ============================>

/*  
	@ login 
	@ forgot password
	@ change password
	@ sign up
*/
$route['login'] = 'NavigationController/login';
$route['login/(:any)'] = 'NavigationController/loginWithAuth/$1';
$route['forgot-password'] = 'NavigationController/forgotPassword';
$route['change-password/(:num)/(:any)/(:any)'] = 'NavigationController/changePassword/$1/$2/$3';
$route['sign-up/(:num)/(:any)'] = 'NavigationController/signUp/$1/$2';

// ============================== Test Codes ============================>
$route['customers'] = 'NavigationController/index';

$route['submit-sample-email'] = 'TestController/sampleEmail';

$route['test'] = 'portal/UserController/test';

$route['test-code'] = 'TestController/index';


// ================================ Methods =============================>
$route['user-login'] = 'IndexController/login';
$route['user-forgot-password'] = 'IndexController/forgotPassword';
$route['user-change-password'] = 'IndexController/changePassword';
$route['user-sign-up'] = 'IndexController/signUp';
$route['user-logout'] = 'IndexController/logout';


/*
| portal section
|
================================ Navigation ===============================>
|
|
*/

$route['contacts'] = 'portal/NavigationController/contacts';
$route['email-template'] = 'portal/NavigationController/emailTemplate';

$route['users'] = 'portal/NavigationController/users';

/*
| portal section
|
================================== Methods ================================>
|
|
*/

$route['load-contacts'] = 'portal/ContactController/loadContacts';
$route['add-contact'] = 'portal/ContactController/addContact';


//test code for uploading pdf
$route['upload-pdf'] = 'portal/ContactController/uploadPdf';
$route['load-sample'] = 'portal/ContactController/loadSample';

//tools/email template
$route['tools/add-category'] = 'portal/EmailTemplateController/addCategory';
$route['tools/load-categories'] = 'portal/EmailTemplateController/loadCategories';
$route['tools/load-templates'] = 'portal/EmailTemplateController/loadTemplates';
$route['tools/add-template'] = 'portal/EmailTemplateController/addTemplate';


//users module
$route['load-users'] = 'portal/UserController/loadUsers';
$route['invite-new-user'] = 'portal/UserController/inviteNewUser';
$route['load-pending-invites'] = 'portal/UserController/loadPendingInvites';