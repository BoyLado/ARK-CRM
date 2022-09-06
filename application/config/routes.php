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

//calendar
$route['calendar'] = 'portal/NavigationController/calendar';

//documents
$route['documents'] = 'portal/NavigationController/documents';
$route['document-preview/(:num)'] = 'portal/NavigationController/documentPreview/$1';

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
//campaign
$route['marketing/load-campaigns'] = 'portal/CampaignController/loadCampaigns';
$route['marketing/add-campaign'] = 'portal/CampaignController/addCampaign';
$route['marketing/select-campaign'] = 'portal/CampaignController/selectCampaign';
$route['marketing/edit-campaign'] = 'portal/CampaignController/editCampaign';

//campaign details
$route['marketing/load-campaign-details'] = 'portal/CampaignController/loadCampaignDetails';

//campaign contacts
$route['marketing/load-selected-contact-campaigns'] = 'portal/CampaignController/loadSelectedContactCampaigns';
$route['marketing/load-unlink-contacts'] = 'portal/CampaignController/loadUnlinkContacts';

//campaign organizations
$route['marketing/load-selected-organization-campaigns'] = 'portal/CampaignController/loadSelectedOrganizationCampaigns';
$route['marketing/load-unlink-organizations'] = 'portal/CampaignController/loadUnlinkOrganizations';

//contacts =======================================================================================================>
$route['marketing/load-contacts'] = 'portal/ContactController/loadContacts';
$route['marketing/add-contact'] = 'portal/ContactController/addContact';
$route['marketing/select-contact'] = 'portal/ContactController/selectContact';
$route['marketing/edit-contact'] = 'portal/ContactController/editContact';

//contact summary
$route['marketing/load-contact-summary'] = 'portal/ContactController/loadContactSummary';

//contact details
$route['marketing/load-contact-details'] = 'portal/ContactController/loadContactDetails';

//contact email histories
$route['marketing/load-contact-emails'] = 'portal/ContactController/loadContactEmails';

//contact documents
$route['marketing/load-contact-documents'] = 'portal/ContactController/loadContactDocuments';
$route['marketing/unlink-contact-document'] = 'portal/ContactController/unlinkContactDocument';
$route['marketing/load-unlink-contact-documents'] = 'portal/ContactController/loadUnlinkContactDocuments';
$route['marketing/add-selected-contact-documents'] = 'portal/ContactController/addSelectedContactDocuments';
$route['marketing/add-contact-document'] = 'portal/ContactController/addContactDocument';

//contact campaigns
$route['marketing/load-contact-campaigns'] = 'portal/ContactController/loadContactCampaigns';
$route['marketing/unlink-contact-campaign'] = 'portal/ContactController/unlinkContactCampaign';
$route['marketing/load-unlink-contact-campaigns'] = 'portal/ContactController/loadUnlinkContactCampaigns';
$route['marketing/add-selected-contact-campaigns'] = 'portal/ContactController/addSelectedContactCampaigns';

//contact comments
$route['marketing/load-contact-comments'] = 'portal/ContactController/loadContactComments';
$route['marketing/add-contact-comment'] = 'portal/ContactController/addContactComment';

//contact emails
$route['marketing/select-contact-email-template'] = 'portal/ContactController/selectEmailTemplate';
$route['marketing/send-contact-email'] = 'portal/ContactController/sendContactEmail';

//organization =====================================================================================================>
$route['marketing/load-organizations'] = 'portal/OrganizationController/loadOrganizations';
$route['marketing/add-organization'] = 'portal/OrganizationController/addOrganization';
$route['marketing/select-organization'] = 'portal/OrganizationController/selectOrganization';
$route['marketing/edit-organization'] = 'portal/OrganizationController/editOrganization';

//organization summary
$route['marketing/load-organization-summary'] = 'portal/OrganizationController/loadOrganizationSummary';

//organization details
$route['marketing/load-organization-details'] = 'portal/OrganizationController/loadOrganizationDetails';

//organization contacts
$route['marketing/load-organization-contacts'] = 'portal/OrganizationController/loadOrganizationContacts';
$route['marketing/unlink-organization-contact'] = 'portal/OrganizationController/unlinkOrganizationContact';
$route['marketing/load-unlink-organization-contacts'] = 'portal/OrganizationController/loadUnlinkOrganizationContacts';
$route['marketing/add-selected-organization-contacts'] = 'portal/OrganizationController/addSelectedOrganizationContacts';

//organization email histories
$route['marketing/load-organization-emails'] = 'portal/OrganizationController/loadOrganizationEmails';

//organization documents
$route['marketing/load-organization-documents'] = 'portal/OrganizationController/loadOrganizationDocuments';
$route['marketing/unlink-organization-document'] = 'portal/OrganizationController/unlinkOrganizationDocument';
$route['marketing/load-unlink-organization-documents'] = 'portal/OrganizationController/loadUnlinkOrganizationDocuments';
$route['marketing/add-selected-organization-documents'] = 'portal/OrganizationController/addSelectedOrganizationDocuments';
$route['marketing/add-organization-document'] = 'portal/OrganizationController/addOrganizationDocument';

//organization campaigns
$route['marketing/load-organization-campaigns'] = 'portal/OrganizationController/loadOrganizationCampaigns';
$route['marketing/unlink-organization-campaign'] = 'portal/OrganizationController/unlinkOrganizationCampaign';
$route['marketing/load-unlink-organization-campaigns'] = 'portal/OrganizationController/loadUnlinkOrganizationCampaigns';
$route['marketing/add-selected-organization-campaigns'] = 'portal/OrganizationController/addSelectedOrganizationCampaigns';

//organization email 
$route['marketing/select-organization-email-template'] = 'portal/OrganizationController/selectEmailTemplate';


//test code for uploading pdf
$route['upload-pdf'] = 'portal/ContactController/uploadPdf';
$route['load-sample'] = 'portal/ContactController/loadSample';

//calendar ==============================================================================================================>

$route['load-calendars'] = 'portal/CalendarController/loadCalendars';
$route['add-calendar'] = 'portal/CalendarController/addCalendar';
$route['select-calendar'] = 'portal/CalendarController/selectCalendar';
$route['edit-calendar'] = 'portal/CalendarController/editCalendar';
$route['remove-calendar'] = 'portal/CalendarController/removeCalendar';

$route['add-event'] = 'portal/EventController/addEvent';
$route['select-event'] = 'portal/EventController/selectEvent';
$route['edit-event'] = 'portal/EventController/editEvent';

$route['add-task'] = 'portal/TaskController/addTask';
$route['select-task'] = 'portal/TaskController/selectTask';
$route['edit-task'] = 'portal/TaskController/editTask';

//documents =============================================================================================================>
$route['load-documents'] = 'portal/DocumentController/loadDocuments';
$route['add-document'] = 'portal/DocumentController/addDocument';
$route['select-document'] = 'portal/DocumentController/selectDocument';

//document contacts
$route['load-selected-contact-documents'] = 'portal/DocumentController/loadSelectedContactDocuments';
$route['load-unlink-contacts'] = 'portal/DocumentController/loadUnlinkContacts';

//document organizations
$route['load-selected-organization-documents'] = 'portal/DocumentController/loadSelectedOrganizationDocuments';
$route['load-unlink-organizations'] = 'portal/DocumentController/loadUnlinkOrganizations';

//tools/email template =================================================================================================>
$route['tools/add-category'] = 'portal/EmailTemplateController/addCategory';
$route['tools/load-categories'] = 'portal/EmailTemplateController/loadCategories';
$route['tools/load-templates'] = 'portal/EmailTemplateController/loadTemplates';
$route['tools/add-template'] = 'portal/EmailTemplateController/addTemplate';
$route['tools/select-template'] = 'portal/EmailTemplateController/selectTemplate';


//users module ========================================================================================================>
$route['load-users'] = 'portal/UserController/loadUsers';
$route['invite-new-user'] = 'portal/UserController/inviteNewUser';
$route['load-pending-invites'] = 'portal/UserController/loadPendingInvites';