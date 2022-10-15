<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class OrganizationController extends BaseController
{
    public function __construct()
    {
        
        

        $this->organizations    = model('Portal/Organizations');
        $this->contacts         = model('Portal/Contacts');
        $this->email_templates  = model('portal/EmailTemplates');
        $this->documents        = model('portal/Documents','documents');
        $this->campaigns        = model('portal/Campaigns','campaigns');
        $this->events           = model('portal/Events','events');
        $this->tasks            = model('portal/Tasks','tasks');


    }

    public function loadOrganizations()
    {
        $data = $this->organizations->loadOrganizations();
        return $this->response->setJSON($data);
    }

    public function addOrganization()
    {
        $this->validation->setRules([
            'txt_organizationName' => [
                'label'  => 'Organization Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Organization Name is required',
                ],
            ],
            'txt_primaryEmail' => [
                'label'  => 'Primary Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Primary Email is required',
                    'valid_email' => 'Email must be valid',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $msgResult = [];

            $arrData = [
                'organization_name'     => $fields['txt_organizationName'],
                'primary_email'         => $fields['txt_primaryEmail'],
                'secondary_email'       => $fields['txt_secondaryEmail'],
                'main_website'          => $fields['txt_mainWebsite'],
                'other_website'         => $fields['txt_otherWebsite'],
                'phone_number'          => $fields['txt_phoneNumber'],
                'fax'                   => $fields['txt_fax'],
                'linkedin_url'          => $fields['txt_linkedinUrl'],
                'facebook_url'          => $fields['txt_facebookUrl'],
                'twitter_url'           => $fields['txt_twitterUrl'],
                'instagram_url'         => $fields['txt_instagramUrl'],
                'industry'              => $fields['slc_industry'],
                'naics_code'            => $fields['txt_naicsCode'],
                'employee_count'        => $fields['txt_employeeCount'],
                'annual_revenue'        => $fields['txt_annualRevenue'],
                'type'                  => $fields['slc_type'],
                'ticket_symbol'         => $fields['txt_ticketSymbol'],
                'member_of'             => ($fields['slc_memberOf'] == "")? NULL : $fields['slc_memberOf'],
                'email_opt_out'         => $fields['slc_emailOptOut'],
                'assigned_to'           => $fields['slc_assignedTo'],
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];

            $insertId = $this->organizations->addOrganization($arrData);
            if($insertId != 0)
            {
                $arrAddressData = [
                    'organization_id'   => $insertId,
                    'billing_street'    => $fields['txt_billingStreet'],
                    'billing_city'      => $fields['txt_billingCity'],
                    'billing_state'     => $fields['txt_billingState'],
                    'billing_zip'       => $fields['txt_billingZip'],
                    'billing_country'   => $fields['txt_billingCountry'],
                    'shipping_street'   => $fields['txt_shippingStreet'],
                    'shipping_city'     => $fields['txt_shippingCity'],
                    'shipping_state'    => $fields['txt_shippingState'],
                    'shipping_zip'      => $fields['txt_shippingZip'],
                    'shipping_country'  => $fields['txt_shippingCountry'],
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];
                $arrDescriptionData = [
                    'organization_id'   => $insertId,
                    'description'       => $fields['txt_description'],
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];

                $result = $this->organizations->addOrganizationDetails($arrAddressData, $arrDescriptionData);
                $msgResult[] = ($result > 0)? "Success" : "Database error";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectOrganization()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->selectOrganization($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function editOrganization()
    {
        $this->validation->setRules([
            'txt_organizationName' => [
                'label'  => 'Organization Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Organization Name is required',
                ],
            ],
            'txt_primaryEmail' => [
                'label'  => 'Primary Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Primary Email is required',
                    'valid_email' => 'Email must be valid',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData['organization_details'] = [
                'organization_name'     => $fields['txt_organizationName'],
                'primary_email'         => $fields['txt_primaryEmail'],
                'secondary_email'       => $fields['txt_secondaryEmail'],
                'main_website'          => $fields['txt_mainWebsite'],
                'other_website'         => $fields['txt_otherWebsite'],
                'phone_number'          => $fields['txt_phoneNumber'],
                'fax'                   => $fields['txt_fax'],
                'linkedin_url'          => $fields['txt_linkedinUrl'],
                'facebook_url'          => $fields['txt_facebookUrl'],
                'twitter_url'           => $fields['txt_twitterUrl'],
                'instagram_url'         => $fields['txt_instagramUrl'],
                'industry'              => $fields['slc_industry'],
                'naics_code'            => $fields['txt_naicsCode'],
                'employee_count'        => $fields['txt_employeeCount'],
                'annual_revenue'        => $fields['txt_annualRevenue'],
                'type'                  => $fields['slc_type'],
                'ticket_symbol'         => $fields['txt_ticketSymbol'],
                'member_of'             => $fields['slc_memberOf'],
                'email_opt_out'         => $fields['slc_emailOptOut'],
                'assigned_to'           => $fields['slc_assignedTo'],
                'updated_by'            => $this->session->get('arkonorllc_user_id')
            ];

            $arrData['organization_address'] = [
                'billing_street'        => $fields['txt_billingStreet'],
                'billing_city'          => $fields['txt_billingCity'],
                'billing_state'         => $fields['txt_billingState'],
                'billing_zip'           => $fields['txt_billingZip'],
                'billing_country'       => $fields['txt_billingCountry'],
                'shipping_street'       => $fields['txt_shippingStreet'],
                'shipping_city'         => $fields['txt_shippingCity'],
                'shipping_state'        => $fields['txt_shippingState'],
                'shipping_zip'          => $fields['txt_shippingZip'],
                'shipping_country'      => $fields['txt_shippingCountry'],
                'updated_by'            => $this->session->get('arkonorllc_user_id')
            ];

            $arrData['organization_description'] = [
                'description'           => $fields['txt_description'],
                'updated_by'            => $this->session->get('arkonorllc_user_id')
            ];

            $result = $this->organizations->editOrganization($arrData, $fields['txt_organizationId']);

            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeOrganization()
    {
        $fields = $this->request->getPost();

        $result = $this->organizations->removeOrganization($fields['organizationId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }








    public function loadOrganizationSummary()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationSummary($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function loadOrganizationDetails()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationDetails($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function loadOrganizationContacts()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationContacts($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function unlinkOrganizationContact()
    {
        $fields = $this->request->getPost();

        $result = $this->organizations->unlinkOrganizationContact($fields['contactId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkOrganizationContacts()
    {
        $fields = $this->request->getGet();

        $organizationId = $fields['organizationId'];

        $arrData = $this->organizations->loadOrganizationContacts($organizationId);

        $arrContactIds = [];
        foreach($arrData as $key => $value)
        {
            $arrContactIds[] = $value['id']; 
        }

        $data = $this->contacts->loadUnlinkContacts($arrContactIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedOrganizationContacts()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        foreach(explode(',',$fields['arrSelectedContacts']) as $key => $value)
        {
            $arrData[] = ['id'=>$value, 'organization_id'=>$fields['organizationId']];
        }

        $result = $this->organizations->addSelectedOrganizationContacts($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }



    public function loadOrganizationEmails()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationEmails($fields['organizationId']);
        return $this->response->setJSON($data);
    }








    public function loadOrganizationDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationDocuments($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function unlinkOrganizationDocument()
    {
        $fields = $this->request->getPost();

        $result = $this->organizations->unlinkOrganizationDocument($fields['organizationDocumentId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkOrganizationDocuments()
    {
        $fields = $this->request->getGet();

        $arrData = $this->organizations->loadOrganizationDocuments($fields['organizationId']);

        $arrDocumentIds = [];
        foreach($arrData as $key => $value)
        {
            $arrDocumentIds[] = $value['document_id']; 
        }

        $data = $this->documents->loadUnlinkDocuments($arrDocumentIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedOrganizationDocuments()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedDocuments']))
        {
            foreach(explode(',',$fields['arrSelectedDocuments']) as $key => $value)
            {
                $arrData[] = ['organization_id'=>$fields['organizationId'], 'document_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedOrganizations']) as $key => $value)
            {
                $arrData[] = ['organization_id'=>$value, 'document_id'=>$fields['documentId']];
            }
        }

        $result = $this->organizations->addSelectedOrganizationDocuments($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function addOrganizationDocument()
    {
        $this->validation->setRules([
            'txt_title' => [
                'label'  => 'Title',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Title is required',
                ],
            ],
            'slc_assignedToDocument' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'title'       => $fields['txt_title'],
                'assigned_to' => $fields['slc_assignedToDocument'],
                'type'        => $fields['slc_uploadtype'],
                'notes'       => $fields['txt_notes'],
                'created_by'  => $this->session->get('arkonorllc_user_id'),
                'created_date'=> date('Y-m-d H:i:s')
            ];
            if($fields['slc_uploadtype'] == 1)
            {
                $arrData['file_name'] = '';
            }
            else
            {
                $arrData['file_url'] = $fields['txt_fileUrl'];
            }

            $documentId = $this->documents->addDocument($arrData);
            if($documentId > 0)
            {
                $arrData = [
                    'organization_id' => $fields['txt_organizationId'],
                    'document_id' => $documentId,
                    'created_by'  => $this->session->get('arkonorllc_user_id'),
                    'created_date'=> date('Y-m-d H:i:s')
                ];

                $result = $this->organizations->addOrganizationDocument($arrData);
                $msgResult[] = ($result > 0)? "Success" : "Database error";
            }
            else
            {
                $msgResult[] = "Unable to save the document";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }









    public function loadOrganizationCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->organizations->loadOrganizationCampaigns($fields['organizationId']);
        return $this->response->setJSON($data);
    }

    public function unlinkOrganizationCampaign()
    {
        $fields = $this->request->getPost();

        $result = $this->organizations->unlinkOrganizationCampaign($fields['organizationCampaignId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkOrganizationCampaigns()
    {
        $fields = $this->request->getGet();

        $arrData = $this->organizations->loadOrganizationCampaigns($fields['organizationId']);

        $arrCampaignIds = [];
        foreach($arrData as $key => $value)
        {
            $arrCampaignIds[] = $value['campaign_id']; 
        }

        $data = $this->campaigns->loadUnlinkOrganizationCampaigns($arrCampaignIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedOrganizationCampaigns()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedCampaigns']))
        {
            foreach(explode(',',$fields['arrSelectedCampaigns']) as $key => $value)
            {
                $arrData[] = ['organization_id'=>$fields['organizationId'], 'campaign_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedOrganizations']) as $key => $value)
            {
                $arrData[] = ['organization_id'=>$value, 'campaign_id'=>$fields['campaignId']];
            }
        }

        $result = $this->organizations->addSelectedOrganizationCampaigns($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }







    

    public function selectEmailTemplate()
    {
        $fields = $this->request->getGet();

        $templateData = $this->email_templates->selectTemplate($fields['templateId']);

        $data = $templateData;

        $contactData = $this->organizations->selectOrganization($fields['organizationId']);

        foreach ($contactData as $key => $value) 
        {
            $newContactData['__'.$key.'__'] = $value; 
        }   

        $data['template_subject'] = load_substitutions($newContactData, $templateData['template_subject']);
        $data['template_content'] = load_substitutions($newContactData, $templateData['template_content']);

        return $this->response->setJSON($data);
    }
}
