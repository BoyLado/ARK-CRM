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

$routes->get('sample','IndexController::sample');



/*
 * --------------------------------------------------------------------
 * INSIDE NAVIGATION
 * --------------------------------------------------------------------
 */

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

//////////////////////////// CAMPAIGNS ////////////////////////////////
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

//////////////////////////// CONTACTS ////////////////////////////////
$routes->get('marketing/load-contacts', 'Portal\ContactController::loadContacts');

//contact campaigns
$routes->post('marketing/add-selected-contact-campaigns', 'portal\ContactController::addSelectedContactCampaigns');

//////////////////////////// USERS ////////////////////////////////
$routes->get('load-users', 'Portal\UserController::loadUsers');
$routes->post('invite-new-user', 'portal\UserController::inviteNewUser');
$routes->get('load-pending-invites', 'portal\UserController::loadPendingInvites');

//////////////////////////// PROFILE ////////////////////////////////
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
