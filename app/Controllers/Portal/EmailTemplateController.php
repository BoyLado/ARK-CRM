<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class EmailTemplateController extends BaseController
{
    public function __construct()
    {
        $this->email_templates = model('Portal/EmailTemplates');
    }

    public function loadCategories()
    {
        $data = $this->email_templates->loadCategories();
        return $this->response->setJSON($data);
    }

    public function addCategory()
    {
        $this->validation->setRules([
            'txt_categoryName' => [
                'label'  => 'Category Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Category Name is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'category_name'         => $fields['txt_categoryName'],
                'category_description'  => $fields['txt_categoryDescription'],
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];
            $result = $this->email_templates->addCategory($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Error! <br>Database error.";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function loadTemplates()
    {
        $data = $this->email_templates->loadTemplates();
        return $this->response->setJSON($data);
    }

    public function addTemplate()
    {
        $this->validation->setRules([
            'slc_category' => [
                'label'  => 'Category Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Category Name is required',
                ],
            ],
            'txt_templateName' => [
                'label'  => 'Template Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Template Name is required',
                ],
            ],
            'slc_templateVisibility' => [
                'label'  => 'Accessibility',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Accessibility is required',
                ],
            ],
            'txt_subject' => [
                'label'  => 'Subject',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Subject is required',
                ],
            ],
            'txt_content' => [
                'label'  => 'Content',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Content is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'category_id'           => $fields['slc_category'],
                'template_name'         => $fields['txt_templateName'],
                'template_description'  => $fields['txt_description'],
                'template_subject'      => $fields['txt_subject'],
                'template_content'      => $fields['txt_content'],
                'template_visibility'   => $fields['slc_templateVisibility'],
                'template_status'       => "1",
                'created_by'            => $this->session->get('arkonorllc_user_id'),
                'created_date'          => date('Y-m-d H:i:s')
            ];
            $result = $this->email_templates->addTemplate($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Error! <br>Database error.";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectTemplate()
    {
        $fields = $this->request->getGet();
        $data = $this->email_templates->selectTemplate($fields['templateId']);
        return $this->response->setJSON($data);
    }
}
