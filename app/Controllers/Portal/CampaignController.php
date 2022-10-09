<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class CampaignController extends BaseController
{
    public function __construct()
    {
        $this->campaigns = model('Portal/Campaigns');
        $this->contacts = model('Portal/Contacts');
        $this->organizations = model('Portal/Organizations');
    }

    public function loadCampaigns()
    {
        $data = $this->campaigns->loadCampaigns();
        return $this->response->setJSON($data);
    }

    public function selectCampaign()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->selectCampaign($fields['campaignId']);
        return $this->response->setJSON($data);
    }

    public function loadCampaignDetails()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadCampaignDetails($fields['campaignId']);
        return $this->response->setJSON($data);
    }











    public function loadSelectedContactCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadSelectedContactCampaigns($fields['campaignId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkContacts()
    {
        $fields = $this->request->getGet();

        $arrData = $this->campaigns->loadContactCampaigns($fields['campaignId']);

        $arrContactIds = [];
        foreach($arrData as $key => $value)
        {
            $arrContactIds[] = $value['contact_id']; 
        }

        $data = $this->contacts->loadUnlinkContacts($arrContactIds);
        return $this->response->setJSON($data);
    }











    public function loadSelectedOrganizationCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->loadSelectedOrganizationCampaigns($fields['campaignId']);
        return $this->response->setJSON($data);
    }
}
