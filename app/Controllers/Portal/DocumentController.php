<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class DocumentController extends BaseController
{
    public function __construct()
    {
        $this->contacts         = model('Portal/Contacts');
        $this->organizations    = model('Portal/Organizations');
        $this->documents        = model('Portal/Documents');
        $this->email_templates  = model('Portal/EmailTemplates');
    }

    public function loadDocuments()
    {
        $data = $this->documents->loadDocuments();
        return $this->response->setJSON($data);
    }

    public function addDocument()
    {
        $this->validation->setRules([
            'txt_title' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
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

            if($fields['slc_uploadtype'] == 2)
            {
                $arrData = [
                    'title'             => $fields['txt_title'],
                    'type'              => $fields['slc_uploadtype'],
                    'file_url'          => $fields['txt_fileUrl'],
                    'notes'             => $fields['txt_notes'],
                    'assigned_to'       => $fields['slc_assignedToDocument'],
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];
            }
            else
            {

            }           

            $result = $this->documents->addDocument($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectDocument()
    {
        $fields = $this->request->getGet();

        $documentId = $fields['documentId'];

        $data = $this->documents->selectDocument($documentId);
        $data['uploadLast'] = dayTime($data['created_date']);
        return $this->response->setJSON($data);
    }

    public function editDocument()
    {
        $this->validation->setRules([
            'txt_title' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
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

            if($fields['slc_uploadtype'] == 2)
            {
                $arrData = [
                    'title'             => $fields['txt_title'],
                    'type'              => $fields['slc_uploadtype'],
                    'file_url'          => $fields['txt_fileUrl'],
                    'notes'             => $fields['txt_notes'],
                    'assigned_to'       => $fields['slc_assignedToDocument'],
                    'created_by'        => $this->session->get('arkonorllc_user_id'),
                    'created_date'      => date('Y-m-d H:i:s')
                ];
            }
            else
            {

            }           

            $result = $this->documents->editDocument($arrData, $fields['txt_documentId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeDocument()
    {
        $fields = $this->request->getPost();

        $result = $this->documents->removeDocument($fields['documentId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
    }




    public function loadSelectedContactDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->documents->loadSelectedContactDocuments($fields['documentId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkContacts()
    {
        $fields = $this->request->getGet();

        $arrData = $this->documents->loadContactDocuments($fields['documentId']);

        $arrContactIds = [];
        foreach($arrData as $key => $value)
        {
            $arrContactIds[] = $value['contact_id']; 
        }

        $data = $this->contacts->loadUnlinkContacts($arrContactIds);
        return $this->response->setJSON($data);
    }
    







    
    public function loadSelectedOrganizationDocuments()
    {
        $fields = $this->request->getGet();

        $data = $this->documents->loadSelectedOrganizationDocuments($fields['documentId']);
        return $this->response->setJSON($data);
    }

    public function loadUnlinkOrganizations()
    {
        $fields = $this->request->getGet();

        $arrData = $this->documents->loadOrganizationDocuments($fields['documentId']);

        $arrOrganizationIds = [];
        foreach($arrData as $key => $value)
        {
            $arrOrganizationIds[] = $value['organization_id']; 
        }

        $data = $this->organizations->loadUnlinkOrganizations($arrOrganizationIds);
        return $this->response->setJSON($data);
    }
}
