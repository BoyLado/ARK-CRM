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

    public function addContact()
    {
        $this->validation->setRules([
            'txt_lastName' => [
                'label'  => 'Last Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Last Name is required',
                ],
            ],
            'slc_reportsTo' => [
                'label'  => 'Reports To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Reports To is required',
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
                'salutation'            => $fields['slc_salutation'],
                'first_name'            => $fields['txt_firstName'],
                'last_name'             => $fields['txt_lastName'],
                'position'              => $fields['txt_position'],
                'organization_id'       => ($fields['slc_companyName'] == "")? NULL : $fields['slc_companyName'],
                'primary_email'         => $fields['txt_primaryEmail'],
                'secondary_email'       => $fields['txt_secondaryEmail'],
                'date_of_birth'         => $fields['txt_birthDate'],
                'intro_letter'          => $fields['slc_introLetter'],
                'office_phone'          => $fields['txt_officePhone'],
                'mobile_phone'          => $fields['txt_mobilePhone'],
                'home_phone'            => $fields['txt_homePhone'],
                'secondary_phone'       => $fields['txt_secondaryPhone'],
                'fax'                   => $fields['txt_fax'],
                'do_not_call'           => $fields['chk_doNotCall'],
                'linkedin_url'          => $fields['txt_linkedinUrl'],
                'twitter_url'           => $fields['txt_twitterUrl'],
                'facebook_url'          => $fields['txt_facebookUrl'],
                'instagram_url'         => $fields['txt_instagramUrl'],
                'lead_source'           => $fields['slc_leadSource'],
                'department'            => $fields['txt_department'],
                'reports_to'            => ($fields['slc_reportsTo'] == "")? NULL : $fields['slc_reportsTo'],
                'assigned_to'           => ($fields['slc_assignedTo'] == "")? NULL : $fields['slc_assignedTo'],
                'email_opt_out'         => $fields['slc_emailOptOut'],
                'unsubscribe_auth_code' => encrypt_code(generate_code()),
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];

            $insertId = $this->contacts->addContact($arrData);
            if($insertId != 0)
            {
                $arrAddressData = [
                    'contact_id'        => $insertId,
                    'mailing_street'    => $fields['txt_mailingStreet'],
                    'mailing_po_box'    => $fields['txt_mailingPOBox'],
                    'mailing_city'      => $fields['txt_mailingCity'],
                    'mailing_state'     => $fields['txt_mailingState'],
                    'mailing_zip'       => $fields['txt_mailingZip'],
                    'mailing_country'   => $fields['txt_mailingCountry'],
                    'other_street'      => $fields['txt_otherStreet'],
                    'other_po_box'      => $fields['txt_otherPOBox'],
                    'other_city'        => $fields['txt_otherCity'],
                    'other_state'       => $fields['txt_otherState'],
                    'other_zip'         => $fields['txt_otherZip'],
                    'other_country'     => $fields['txt_otherCountry'],
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];
                $arrDescriptionData = [
                    'contact_id'        => $insertId,
                    'description'       => $fields['txt_description'],
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];

                $result = $this->contacts->addContactDetails($arrAddressData, $arrDescriptionData);
                $msgResult[] = ($result > 0)? "Success" : "Database error";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectContact()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->selectContact($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function editContact()
    {
        $this->validation->setRules([
            'txt_lastName' => [
                'label'  => 'Last Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Last Name is required',
                ],
            ],
            'slc_reportsTo' => [
                'label'  => 'Reports To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Reports To is required',
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

            $arrData['contact_details'] = [
                'salutation'        => $fields['slc_salutation'],
                'first_name'        => $fields['txt_firstName'],
                'last_name'         => $fields['txt_lastName'],
                'position'          => $fields['txt_position'],
                'organization_id'   => ($fields['slc_companyName'] == "")? NULL : $fields['slc_companyName'],
                'primary_email'     => $fields['txt_primaryEmail'],
                'secondary_email'   => $fields['txt_secondaryEmail'],
                'date_of_birth'     => $fields['txt_birthDate'],
                'intro_letter'      => $fields['slc_introLetter'],
                'office_phone'      => $fields['txt_officePhone'],
                'mobile_phone'      => $fields['txt_mobilePhone'],
                'home_phone'        => $fields['txt_homePhone'],
                'secondary_phone'   => $fields['txt_secondaryPhone'],
                'fax'               => $fields['txt_fax'],
                'do_not_call'       => $fields['chk_doNotCall'],
                'linkedin_url'      => $fields['txt_linkedinUrl'],
                'twitter_url'       => $fields['txt_twitterUrl'],
                'facebook_url'      => $fields['txt_facebookUrl'],
                'instagram_url'     => $fields['txt_instagramUrl'],
                'lead_source'       => $fields['slc_leadSource'],
                'department'        => $fields['txt_department'],
                'reports_to'        => ($fields['slc_reportsTo'] == "")? NULL : $fields['slc_reportsTo'],
                'assigned_to'       => ($fields['slc_assignedTo'] == "")? NULL : $fields['slc_assignedTo'],
                'email_opt_out'     => $fields['slc_emailOptOut'],
                'updated_by'        => $this->session->get('arkonorllc_user_id')
            ];

            $arrData['contact_address'] = [
                'mailing_street'    => $fields['txt_mailingStreet'],
                'mailing_po_box'    => $fields['txt_mailingPOBox'],
                'mailing_city'      => $fields['txt_mailingCity'],
                'mailing_state'     => $fields['txt_mailingState'],
                'mailing_zip'       => $fields['txt_mailingZip'],
                'mailing_country'   => $fields['txt_mailingCountry'],
                'other_street'      => $fields['txt_otherStreet'],
                'other_po_box'      => $fields['txt_otherPOBox'],
                'other_city'        => $fields['txt_otherCity'],
                'other_state'       => $fields['txt_otherState'],
                'other_zip'         => $fields['txt_otherZip'],
                'other_country'     => $fields['txt_otherCountry'],
                'updated_by'        => $this->session->get('arkonorllc_user_id')
            ];

            $arrData['contact_description'] = [
                'description'       => $fields['txt_description'],
                'updated_by'        => $this->session->get('arkonorllc_user_id')
            ];

            $result = $this->contacts->editContact($arrData, $fields['txt_contactId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeContact()
    {
        $fields = $this->request->getPost();

        $result = $this->contacts->removeContact($fields['contactId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadContactSummary()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactSummary($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function loadContactDetails()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactDetails($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function loadContactActivities()
    {
        $fields = $this->request->getGet();

        $arrData['arrEvents'] = $this->contacts->loadContactEvents($fields['contactId']);
        $arrData['arrTasks'] = $this->contacts->loadContactTasks($fields['contactId']);

        $data = [];
        foreach ($arrData['arrEvents'] as $key => $value) 
        {
            $data[] = [
                'eventId'           => $value['id'],
                'status'                => $value['status'],
                'activityType'  => 'Event',
                'subject'           => $value['subject'],
                'startDate'         => $value['start_date'],
                'startTime'         => $value['start_time'],
                'endDate'           => $value['end_date'],
                'endTime'           => $value['end_time'],
                'assignedTo'        => $value['']
            ];
        }

        foreach ($arrData['arrTasks'] as $key => $value) 
        {
            
        }

        return $this->response->setJSON($data);
    }

    public function loadContactEmails()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactEmails($fields['contactId']);
        return $this->response->setJSON($data);
    }











    // contact documents

    public function loadContactDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactDocuments($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function unlinkContactDocument()
    {
        $fields = $this->request->getPost();

        $result = $this->contacts->unlinkContactDocument($fields['contactDocumentId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkContactDocuments()
    {
        $fields = $this->request->getGet();

        $arrData = $this->contacts->loadContactDocuments($fields['contactId']);

        $arrDocumentIds = [];
        foreach($arrData as $key => $value)
        {
            $arrDocumentIds[] = $value['document_id']; 
        }

        $data = $this->documents->loadUnlinkDocuments($arrDocumentIds);
        return $this->response->setJSON($data);
    }

    public function addSelectedContactDocuments()
    {
        $fields = $this->request->getPost();

        $arrData = [];
        if(isset($fields['arrSelectedDocuments']))
        {
            foreach(explode(',',$fields['arrSelectedDocuments']) as $key => $value)
            {
                $arrData[] = ['contact_id'=>$fields['contactId'], 'document_id'=>$value];
            }
        }
        else
        {
            foreach(explode(',',$fields['arrSelectedContacts']) as $key => $value)
            {
                $arrData[] = ['contact_id'=>$value, 'document_id'=>$fields['documentId']];
            }
        }

        $result = $this->contacts->addSelectedContactDocuments($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function addContactDocument()
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
                    'contact_id' => $fields['txt_contactId'],
                    'document_id' => $documentId,
                    'created_by'  => $this->session->get('arkonorllc_user_id'),
                    'created_date'=> date('Y-m-d H:i:s')
                ];

                $result = $this->contacts->addContactDocument($arrData);
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












    //contact campaign
    public function loadContactCampaigns()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactCampaigns($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function unlinkContactCampaign()
    {
        $fields = $this->request->getPost();

        $result = $this->contacts->unlinkContactCampaign($fields['contactCampaignId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }

    public function loadUnlinkContactCampaigns()
    {
        $fields = $this->request->getGet();

        $arrData = $this->contacts->loadContactCampaigns($fields['contactId']);

        $arrCampaignIds = [];
        foreach($arrData as $key => $value)
        {
            $arrCampaignIds[] = $value['campaign_id']; 
        }

        $data = $this->campaigns->loadUnlinkContactCampaigns($arrCampaignIds);
        return $this->response->setJSON($data);
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
    










    //contact comments

    public function loadContactComments()
    {
        $fields = $this->request->getGet();

        $data = $this->contacts->loadContactComments($fields['contactId']);
        return $this->response->setJSON($data);
    }

    public function addContactComment()
    {
        $params = getParams();

        $arrData = [
            'contact_id'        => $params['txt_contactId'],
            'comment_id'        => NULL,
            'comment'           => $params['txt_comments'],
            'comment_index' => $params['txt_commentIndex'],
            'created_by'        => $this->session->userdata('arkonorllc_user_id'),
            'created_date'  => date('Y-m-d H:i:s')
        ];
        $result = $this->contacts->addContactComment($arrData);
        $msgResult = ($result > 0)? "Success" : "Database error";
    }

    public function selectEmailTemplate()
    {
        $fields = $this->request->getGet();

        $templateData = $this->email_templates->selectTemplate($fields['templateId']);

        $data = $templateData;

        $contactData = $this->contacts->selectContact($fields['contactId']);

        foreach ($contactData as $key => $value) 
        {
            $newContactData['__'.$key.'__'] = $value; 
        }   

        $data['template_subject'] = load_substitutions($newContactData, $templateData['template_subject']);
        $data['template_content'] = load_substitutions($newContactData, $templateData['template_content']);

        return $this->response->setJSON($data);
    }

    public function sendContactEmail()
    {
        $fields = $this->request->getPost();

        $emailSender    = 'ajhay.work@gmail.com';
        $emailReceiver  = $fields['txt_to'];

        $arrData = $this->contacts->selectContact($fields['txt_contactId']);

        $data['subjectTitle'] = $fields['txt_subject'];
        $data['emailContent'] = $fields['txt_content'];
        $unsubscribeLink = "contact-unsubscribe/".$fields['txt_contactId']."/".decrypt_code($arrData['unsubscribe_auth_code'])."/".$fields['txt_to'];
        $data['unsubscribeLink'] = (isset($fields['chk_unsubscribe']))? $unsubscribeLink : "";

        $emailResult = sendSliceMail('contact_email',$emailSender,$emailReceiver,$data);

        $arrData = [];
        if($emailResult == 1)
        {
            $arrData = [
                'email_subject' => $fields['txt_subject'],
                'email_content' => $fields['txt_content'],
                'email_status'  => 'Sent',
                'sent_to'       => $fields['txt_contactId'],
                'sent_by'       => $this->session->get('arkonorllc_user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            ];
        }
        else
        {
            $arrData = [
                'email_subject' => $fields['txt_subject'],
                'email_content' => $fields['txt_content'],
                'email_status'  => 'Not sent',
                'sent_to'       => $fields['txt_contactId'],
                'sent_by'       => $this->session->get('arkonorllc_user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->contacts->saveContactEmails($arrData);
        $msgResult[] = ($result > 0)? "Success" : "Database Error";

        return $this->response->setJSON($msgResult);
    }
}
