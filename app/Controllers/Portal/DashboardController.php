<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->campaigns        = model('Portal/Campaigns');
        $this->contacts         = model('Portal/Contacts');
        $this->organizations    = model('Portal/Organizations');
    }

    public function loadAllCampaigns()
    {
        $arrResult = $this->campaigns->loadCampaigns();
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadAllContacts()
    {
        $arrResult = $this->contacts->loadContacts();
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadAllOrganizations()
    {
        $arrResult = $this->organizations->loadOrganizations();
        $data = ($arrResult == null)? 0 : count($arrResult);
        return $this->response->setJSON($data);
    }

    public function loadAllThirdParties()
    {
        
    }
}
