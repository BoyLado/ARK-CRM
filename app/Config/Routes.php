<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('NavigationController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function(){
    return view('404');
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'NavigationController');

/*
 * --------------------------------------------------------------------
 * OUTSIDE NAVIGATIONS
 * --------------------------------------------------------------------
 */
$routes->get('login', 'NavigationController::login');
$routes->get('login/(:any)', 'NavigationController::loginWithAuth/$1');
$routes->get('forgot-password', 'NavigationController::forgotPassword');
$routes->get('change-password/(:num)/(:any)/(:any)', 'NavigationController::changePassword/$1/$2/$3');
$routes->get('sign-up/(:num)/(:any)', 'NavigationController::signUp/$1/$2');

/*
 * --------------------------------------------------------------------
 * OUTSIDE METHODS
 * --------------------------------------------------------------------
 */
$routes->post('user-login', 'IndexController::login');
$routes->post('user-forgot-password', 'IndexController::forgotPassword');
$routes->post('user-change-password', 'IndexController::changePassword');
$routes->post('user-sign-up', 'IndexController::signUp');
$routes->get('user-logout', 'IndexController::logout');

$routes->get('contact-unsubscribe/(:num)/(:any)/(:any)','UnsubscribeController::contactUnsubscribe/$1/$2/$3');
$routes->get('contact-confirmation/(:num)/(:any)/(:any)','UnsubscribeController::contactConfirmation/$1/$2/$3');

$routes->get('sample','IndexController::sample');



/*
 * --------------------------------------------------------------------
 * INSIDE NAVIGATION
 * --------------------------------------------------------------------
 */
//////////////////////////// DASHBOARD ////////////////////////////////
$routes->get('dashboard', 'Portal\NavigationController::dashboard');

//////////////////////////// MARKETING ////////////////////////////////
$routes->get('campaigns', 'Portal\NavigationController::campaigns');
$routes->get('campaign-preview/(:num)', 'Portal\NavigationController::campaignPreview/$1');
$routes->get('contacts', 'Portal\NavigationController::contacts');
$routes->get('contact-preview/(:num)', 'Portal\NavigationController::contactPreview/$1');
$routes->get('organizations', 'Portal\NavigationController::organizations');
$routes->get('organization-preview/(:num)', 'portal\NavigationController::organizationPreview/$1');

//////////////////////////// AGENDA ////////////////////////////////
$routes->get('agenda', 'portal\NavigationController::agenda');

//////////////////////////// CALENDAR ////////////////////////////////
$routes->get('calendar', 'portal\NavigationController::calendar');

//////////////////////////// DOCUMENTS ////////////////////////////////
$routes->get('documents', 'portal\NavigationController::documents');
$routes->get('document-preview/(:num)', 'portal\NavigationController::documentPreview/$1');

//////////////////////////// TOOLS ////////////////////////////////
$routes->get('email-template', 'portal\NavigationController::emailTemplate');

//////////////////////////// USERS ////////////////////////////////
$routes->get('users', 'portal\NavigationController::users');

//////////////////////////// PROFILE ////////////////////////////////
$routes->get('profile', 'portal\NavigationController::profile');

/*
 * --------------------------------------------------------------------
 * INSIDE METHODS
 * --------------------------------------------------------------------
 */

///////////////////////////////////////////////////////////////////////
//////////////////////////// DASHBOARD ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('dashboard/load-all-campaigns','portal\DashboardController::loadAllCampaigns');
$routes->get('dashboard/load-all-contacts','portal\DashboardController::loadAllContacts');
$routes->get('dashboard/load-all-organizations','portal\DashboardController::loadAllOrganizations');
$routes->get('dashboard/load-all-third-parties','portal\DashboardController::loadAllThirdParties');


///////////////////////////////////////////////////////////////////////
//////////////////////////// CAMPAIGNS ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('marketing/load-campaigns','portal\CampaignController::loadCampaigns');
$routes->post('marketing/add-campaign','portal\CampaignController::addCampaign');
$routes->get('marketing/select-campaign','portal\CampaignController::selectCampaign');
$routes->post('marketing/edit-campaign','portal\CampaignController::editCampaign');
$routes->post('marketing/remove-campaign','portal\CampaignController::removeCampaign');

//campaign details
$routes->get('marketing/load-campaign-details','portal\CampaignController::loadCampaignDetails');

//campaign contacts
$routes->get('marketing/load-selected-contact-campaigns','portal\CampaignController::loadSelectedContactCampaigns');
$routes->get('marketing/load-unlink-contacts','portal\CampaignController::loadUnlinkContacts');

//campaign organizations
$routes->get('marketing/load-selected-organization-campaigns','portal\CampaignController::loadSelectedOrganizationCampaigns');
$routes->get('marketing/load-unlink-organizations','portal\CampaignController::loadUnlinkOrganizations');


//////////////////////////////////////////////////////////////////////
//////////////////////////// CONTACTS ////////////////////////////////
//////////////////////////////////////////////////////////////////////

$routes->get('marketing/load-contacts','Portal\ContactController::loadContacts');
$routes->post('marketing/add-contact','portal\ContactController::addContact');
$routes->get('marketing/select-contact','portal\ContactController::selectContact');
$routes->post('marketing/edit-contact','portal\ContactController::editContact');
$routes->post('marketing/remove-contact','portal\ContactController::removeContact');

//contact summary
$routes->get('marketing/load-contact-summary','portal\ContactController::loadContactSummary');

//contact details
$routes->get('marketing/load-contact-details','portal\ContactController::loadContactDetails');

//contact activities
$routes->get('marketing/load-contact-activities','portal\ContactController::loadContactActivities');

//contact email histories
$routes->get('marketing/load-contact-emails','portal\ContactController::loadContactEmails');

//contact documents
$routes->get('marketing/load-contact-documents','portal\ContactController::loadContactDocuments');
$routes->post('marketing/unlink-contact-document','portal\ContactController::unlinkContactDocument');
$routes->get('marketing/load-unlink-contact-documents','portal\ContactController::loadUnlinkContactDocuments');
$routes->post('marketing/add-selected-contact-documents','portal\ContactController::addSelectedContactDocuments');
$routes->post('marketing/add-contact-document','portal\ContactController::addContactDocument');

//contact campaigns
$routes->get('marketing/load-contact-campaigns','portal\ContactController::loadContactCampaigns');
$routes->post('marketing/unlink-contact-campaign','portal\ContactController::unlinkContactCampaign');
$routes->get('marketing/load-unlink-contact-campaigns','portal\ContactController::loadUnlinkContactCampaigns');
$routes->post('marketing/add-selected-contact-campaigns','portal\ContactController::addSelectedContactCampaigns');

//contact comments
$routes->get('marketing/load-contact-comments','portal\ContactController::loadContactComments');
$routes->post('marketing/add-contact-comment','portal\ContactController::addContactComment');

//contact emails
$routes->get('marketing/select-contact-email-template','portal\ContactController::selectEmailTemplate');
$routes->post('marketing/send-contact-email','portal\ContactController::sendContactEmail');


///////////////////////////////////////////////////////////////////////////
//////////////////////////// ORGANIZATIONS ////////////////////////////////
///////////////////////////////////////////////////////////////////////////

$routes->get('marketing/load-organizations','portal\OrganizationController::loadOrganizations');
$routes->post('marketing/add-organization','portal\OrganizationController::addOrganization');
$routes->get('marketing/select-organization','portal\OrganizationController::selectOrganization');
$routes->post('marketing/edit-organization','portal\OrganizationController::editOrganization');
$routes->post('marketing/remove-organization','portal\OrganizationController::removeOrganization');

//organization summary
$routes->get('marketing/load-organization-summary','portal\OrganizationController::loadOrganizationSummary');

//organization details
$routes->get('marketing/load-organization-details','portal\OrganizationController::loadOrganizationDetails');

//organization contacts
$routes->get('marketing/load-organization-contacts','portal\OrganizationController::loadOrganizationContacts');
$routes->post('marketing/unlink-organization-contact','portal\OrganizationController::unlinkOrganizationContact');
$routes->get('marketing/load-unlink-organization-contacts','portal\OrganizationController::loadUnlinkOrganizationContacts');
$routes->post('marketing/add-selected-organization-contacts','portal\OrganizationController::addSelectedOrganizationContacts');

//organization email histories
$routes->get('marketing/load-organization-emails','portal\OrganizationController::loadOrganizationEmails');

//organization documents
$routes->get('marketing/load-organization-documents','portal\OrganizationController::loadOrganizationDocuments');
$routes->post('marketing/unlink-organization-document','portal\OrganizationController::unlinkOrganizationDocument');
$routes->get('marketing/load-unlink-organization-documents','portal\OrganizationController::loadUnlinkOrganizationDocuments');
$routes->post('marketing/add-selected-organization-documents','portal\OrganizationController::addSelectedOrganizationDocuments');
$routes->post('marketing/add-organization-document','portal\OrganizationController::addOrganizationDocument');

//organization campaigns
$routes->get('marketing/load-organization-campaigns','portal\OrganizationController::loadOrganizationCampaigns');
$routes->post('marketing/unlink-organization-campaign','portal\OrganizationController::unlinkOrganizationCampaign');
$routes->get('marketing/load-unlink-organization-campaigns','portal\OrganizationController::loadUnlinkOrganizationCampaigns');
$routes->post('marketing/add-selected-organization-campaigns','portal\OrganizationController::addSelectedOrganizationCampaigns');

//organization email 
$routes->get('marketing/select-organization-email-template','portal\OrganizationController::selectEmailTemplate');


///////////////////////////////////////////////////////////////////////
//////////////////////////// CALENDARS ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('load-calendars','portal\CalendarController::loadCalendars');
$routes->post('add-calendar','portal\CalendarController::addCalendar');
$routes->get('select-calendar','portal\CalendarController::selectCalendar');
$routes->post('edit-calendar','portal\CalendarController::editCalendar');
$routes->post('remove-calendar','portal\CalendarController::removeCalendar');

$routes->post('add-event','portal\EventController/ad::Event');
$routes->get('select-event','portal\EventController/se::ectEvent');
$routes->post('edit-event','portal\EventController/ed::tEvent');

$routes->post('add-task','portal\TaskController/add::ask');
$routes->get('select-task','portal\TaskController/sel::ctTask');
$routes->post('edit-task','portal\TaskController/edi::Task');


///////////////////////////////////////////////////////////////////////
//////////////////////////// DOCUMENTS ////////////////////////////////
///////////////////////////////////////////////////////////////////////

$routes->get('load-documents','portal\DocumentController::loadDocuments');
$routes->post('add-document','portal\DocumentController::addDocument');
$routes->get('select-document','portal\DocumentController::selectDocument');
$routes->post('edit-document','portal\DocumentController::editDocument');
$routes->post('remove-document','portal\DocumentController::removeDocument');

//document contacts
$routes->get('load-selected-contact-documents','portal\DocumentController::loadSelectedContactDocuments');
$routes->get('load-unlink-contacts','portal\DocumentController::loadUnlinkContacts');

//document organizations
$routes->get('load-selected-organization-documents','portal\DocumentController::loadSelectedOrganizationDocuments');
$routes->get('load-unlink-organizations','portal\DocumentController::loadUnlinkOrganizations');


////////////////////////////////////////////////////////////////////////////
//////////////////////////// EMAIL TEMPLATE ////////////////////////////////
////////////////////////////////////////////////////////////////////////////

$routes->post('tools/add-category','portal\EmailTemplateController::addCategory');
$routes->get('tools/load-categories','portal\EmailTemplateController::loadCategories');
$routes->get('tools/load-templates','portal\EmailTemplateController::loadTemplates');
$routes->post('tools/add-template','portal\EmailTemplateController::addTemplate');
$routes->get('tools/select-template','portal\EmailTemplateController::selectTemplate');


///////////////////////////////////////////////////////////////////
//////////////////////////// USERS ////////////////////////////////
///////////////////////////////////////////////////////////////////

$routes->get('load-users', 'Portal\UserController::loadUsers');
$routes->post('invite-new-user', 'portal\UserController::inviteNewUser');
$routes->get('load-pending-invites', 'portal\UserController::loadPendingInvites');


/////////////////////////////////////////////////////////////////////
//////////////////////////// PROFILE ////////////////////////////////
/////////////////////////////////////////////////////////////////////

$routes->get('load-profile', 'portal\UserController::loadProfile');
$routes->post('change-profile-picture', 'portal\UserController::changeProfilePicture');
$routes->get('load-details', 'portal\UserController::loadDetails');
$routes->post('edit-details', 'portal\UserController::editDetails');
$routes->post('edit-password', 'portal\UserController::editPassword');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
