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

    public function addCampaign()
    {
        $this->validation->setRules([
            'txt_campaignName' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
            'txt_expectedCloseDate' => [
                'label'  => 'Expected Close Date',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Expected Close Date is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            $arrData = [
                'campaign_name'             => $fields['txt_campaignName'],
                'campaign_status'           => $fields['slc_campaignStatus'],
                'product'                   => $fields['txt_product'],
                'expected_close_date'       => $fields['txt_expectedCloseDate'],
                'target_size'               => $fields['txt_targetSize'],
                'campaign_type'             => $fields['slc_campaignType'],
                'target_audience'           => $fields['txt_targetAudience'],
                'sponsor'                   => $fields['txt_sponsor'],
                'num_sent'                  => $fields['txt_numSent'],
                'assigned_to'               => $fields['slc_assignedTo'],
                'budget_cost'               => $fields['txt_budgetCost'],
                'expected_response'         => $fields['txt_expectedResponse'],
                'expected_sales_count'      => $fields['txt_expectedSalesCount'],
                'expected_response_count'   => $fields['txt_expectedResponseCount'],
                'expected_roi'              => $fields['txt_expectedROI'],
                'actual_cost'               => $fields['txt_actualCost'],
                'expected_revenue'          => $fields['txt_expectedRevenue'],
                'actual_sales_count'        => $fields['txt_actualSalesCount'],
                'actual_response_count'     => $fields['txt_actualResponseCount'],
                'actual_roi'                => $fields['txt_actualROI'],
                'campaign_description'      => $fields['txt_description'],
                'created_by'                => $this->session->get('arkonorllc_user_id'),
                'created_date'              => date('Y-m-d H:i:s')
            ];

            $result = $this->campaigns->addCampaign($arrData);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function selectCampaign()
    {
        $fields = $this->request->getGet();

        $data = $this->campaigns->selectCampaign($fields['campaignId']);
        return $this->response->setJSON($data);
    }

    public function editCampaign()
    {
        $this->validation->setRules([
            'txt_campaignName' => [
                'label'  => 'Campaign Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Campaign Name is required',
                ],
            ],
            'slc_assignedTo' => [
                'label'  => 'Assigned To',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Assigned To is required',
                ],
            ],
            'txt_expectedCloseDate' => [
                'label'  => 'Expected Close Date',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Expected Close Date is required',
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            $arrData = [
                'campaign_name'             => $fields['txt_campaignName'],
                'campaign_status'           => $fields['slc_campaignStatus'],
                'product'                   => $fields['txt_product'],
                'expected_close_date'       => $fields['txt_expectedCloseDate'],
                'target_size'               => $fields['txt_targetSize'],
                'campaign_type'             => $fields['slc_campaignType'],
                'target_audience'           => $fields['txt_targetAudience'],
                'sponsor'                   => $fields['txt_sponsor'],
                'num_sent'                  => $fields['txt_numSent'],
                'assigned_to'               => $fields['slc_assignedTo'],
                'budget_cost'               => $fields['txt_budgetCost'],
                'expected_response'         => $fields['txt_expectedResponse'],
                'expected_sales_count'      => $fields['txt_expectedSalesCount'],
                'expected_response_count'   => $fields['txt_expectedResponseCount'],
                'expected_roi'              => $fields['txt_expectedROI'],
                'actual_cost'               => $fields['txt_actualCost'],
                'expected_revenue'          => $fields['txt_expectedRevenue'],
                'actual_sales_count'        => $fields['txt_actualSalesCount'],
                'actual_response_count'     => $fields['txt_actualResponseCount'],
                'actual_roi'                => $fields['txt_actualROI'],
                'campaign_description'      => $fields['txt_description'],
                'updated_by'                => $this->session->get('arkonorllc_user_id')
            ];

            $result = $this->campaigns->editCampaign($arrData, $fields['txt_campaignId']);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

    public function removeCampaign()
    {
        $fields = $this->request->getPost();

        $result = $this->campaigns->removeCampaign($fields['campaignId']);
        $msgResult[] = ($result > 0)? "Success" : "Database error";
        return $this->response->setJSON($msgResult);
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

    public function loadUnlinkOrganizations()
    {
        $fields = $this->request->getGet();

        $arrData = $this->campaigns->loadOrganizationCampaigns($fields['campaignId']);

        $arrOrganizationIds = [];
        foreach($arrData as $key => $value)
        {
            $arrOrganizationIds[] = $value['organization_id']; 
        }

        $data = $this->organizations->loadUnlinkOrganizations($arrOrganizationIds);
        return $this->response->setJSON($data);
    }
}
