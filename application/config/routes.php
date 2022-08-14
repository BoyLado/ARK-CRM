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

$route['sample-time'] = 'TestController/sampleTime';


// ================================ Methods =============================>
$route['user-login'] = 'IndexController/login';
$route['user-forgot-password'] = 'IndexController/forgotPassword';
$route['user-change-password'] = 'IndexController/changePassword';
$route['user-sign-up'] = 'IndexController/signUp';
$route['user-logout'] = 'IndexController/logout';

$route['contact-unsubscribe/(:num)/(:any)/(:any)'] = 'UnsubscribeController/contactUnsubscribe/$1/$2/$3';
$route['contact-confirmation/(:num)/(:any)/(:any)'] = 'UnsubscribeController/contactConfirmation/$1/$2/$3';



/*
| portal section
|
================================ Navigation ===============================>
|
|
*/

// marketing
$route['campaigns'] = 'portal/NavigationController/campaigns';
$route['campaign-preview/(:num)'] = 'portal/NavigationController/campaignPreview/$1';
$route['contacts'] = 'portal/NavigationController/contacts';
$route['contact-preview/(:num)'] = 'portal/NavigationController/contactPreview/$1';
$route['organizations'] = 'portal/NavigationController/organizations';
$route['organization-preview/(:num)'] = 'portal/NavigationController/organizationPreview/$1';

// tools
$route['email-template'] = 'portal/NavigationController/emailTemplate';

// users
$route['users'] = 'portal/NavigationController/users';

/*
| portal section
|
================================== Methods ================================>
|
|
*/
$route['marketing/load-campaigns'] = 'portal/CampaignController/loadCampaigns';
$route['marketing/add-campaign'] = 'portal/CampaignController/addCampaign';
$route['marketing/select-campaign'] = 'portal/CampaignController/selectCampaign';
$route['marketing/edit-campaign'] = 'portal/CampaignController/editCampaign';
$route['marketing/load-campaign-details'] = 'portal/CampaignController/loadCampaignDetails';
$route['marketing/load-selected-contact-campaigns'] = 'portal/CampaignController/loadSelectedContactCampaigns';
$route['marketing/load-unlink-contacts'] = 'portal/CampaignController/loadUnlinkContacts';
$route['marketing/load-selected-organization-campaigns'] = 'portal/CampaignController/loadSelectedOrganizationCampaigns';
$route['marketing/load-unlink-organizations'] = 'portal/CampaignController/loadUnlinkOrganizations';

$route['marketing/load-contacts'] = 'portal/ContactController/loadContacts';
$route['marketing/add-contact'] = 'portal/ContactController/addContact';
$route['marketing/select-contact'] = 'portal/ContactController/selectContact';
$route['marketing/edit-contact'] = 'portal/ContactController/editContact';
$route['marketing/load-contact-summary'] = 'portal/ContactController/loadContactSummary';
$route['marketing/load-contact-details'] = 'portal/ContactController/loadContactDetails';
$route['marketing/load-contact-emails'] = 'portal/ContactController/loadContactEmails';
$route['marketing/load-contact-campaigns'] = 'portal/ContactController/loadContactCampaigns';
$route['marketing/load-unlink-contact-campaigns'] = 'portal/ContactController/loadUnlinkContactCampaigns';
$route['marketing/add-contact-campaign'] = 'portal/ContactController/addContactCampaign';
$route['marketing/unlink-contact-campaign'] = 'portal/ContactController/unlinkContactCampaign';
$route['marketing/load-contact-comments'] = 'portal/ContactController/loadContactComments';
$route['marketing/add-contact-comment'] = 'portal/ContactController/addContactComment';
$route['marketing/select-contact-email-template'] = 'portal/ContactController/selectEmailTemplate';
$route['marketing/send-contact-email'] = 'portal/ContactController/sendContactEmail';

$route['marketing/load-organizations'] = 'portal/OrganizationController/loadOrganizations';
$route['marketing/add-organization'] = 'portal/OrganizationController/addOrganization';
$route['marketing/select-organization'] = 'portal/OrganizationController/selectOrganization';
$route['marketing/load-organization-contacts'] = 'portal/OrganizationController/loadOrganizationContacts';
$route['marketing/unlink-organization-contact'] = 'portal/OrganizationController/unlinkOrganizationContact';
$route['marketing/load-organization-emails'] = 'portal/OrganizationController/loadOrganizationEmails';
$route['marketing/add-organization-campaign'] = 'portal/OrganizationController/addOrganizationCampaign';
$route['marketing/unlink-organization-campaign'] = 'portal/OrganizationController/unlinkOrganizationCampaign';
$route['marketing/select-organization-email-template'] = 'portal/OrganizationController/selectEmailTemplate';


//test code for uploading pdf
$route['upload-pdf'] = 'portal/ContactController/uploadPdf';
$route['load-sample'] = 'portal/ContactController/loadSample';

//tools/email template
$route['tools/add-category'] = 'portal/EmailTemplateController/addCategory';
$route['tools/load-categories'] = 'portal/EmailTemplateController/loadCategories';
$route['tools/load-templates'] = 'portal/EmailTemplateController/loadTemplates';
$route['tools/add-template'] = 'portal/EmailTemplateController/addTemplate';
$route['tools/select-template'] = 'portal/EmailTemplateController/selectTemplate';


//users module
$route['load-users'] = 'portal/UserController/loadUsers';
$route['invite-new-user'] = 'portal/UserController/inviteNewUser';
$route['load-pending-invites'] = 'portal/UserController/loadPendingInvites';