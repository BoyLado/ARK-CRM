<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class ContactController extends BaseController
{
    public function __construct()
    {
        
        


        $this->contacts         = model('Portal/Contacts');
        $this->email_templates  = model('portal/EmailTemplates');
        $this->documents        = model('portal/Documents','documents');
        $this->campaigns        = model('portal/Campaigns','campaigns');
        $this->events           = model('portal/Events','events');
        $this->tasks            = model('portal/Tasks','tasks');


    }

    public function loadContacts()
    {
        if(session()->has('arkonorllc_user_loggedIn'))
        {
            if(session()->get('arkonorllc_user_loggedIn'))
            {
                $arrResult = $this->contacts->loadContacts();
                return $this->response->setJSON($arrResult);
            }
            else
            {
                return $this->response->setJSON('Access denied!');
            }
        }
        else
        {
            return $this->response->setJSON('Access denied!');
        }        
    }

    public function addSelectedContactCampaigns()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedCampaigns']))
        {
            foreach(explode(',',$fields['arrSelectedCampaigns']) as $key => $value)
            {
                $arrData[] = ['contact_id'=>$fields['contactId'], 'campaign_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedContacts']) as $key => $value)
            {
                $arrData[] = ['contact_id'=>$value, 'campaign_id'=>$fields['campaignId']];
            }
        }

        $result = $this->contacts->addSelectedContactCampaigns($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }
}
