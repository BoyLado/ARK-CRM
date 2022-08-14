<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class CampaignController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('SliceLibrary',null,'slice');

		if(!$this->session->has_userdata('arkonorllc_user_id'))
		{
		  redirect(base_url(),'refresh');
		}

		$this->load->database();
		$this->load->model('portal/Campaigns','campaigns');
		$this->load->model('portal/Contacts','contacts');
		$this->load->model('portal/Organizations','organizations');
	}

	public function loadCampaigns()
	{
		$data = $this->campaigns->loadCampaigns();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addCampaign()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_campaignName', 'Campaign Name', 'required');
		$this->form_validation->set_rules('slc_assignedTo', 'Assigned To', 'required');
		$this->form_validation->set_rules('txt_expectedCloseDate', 'Expected Close Date', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$arrData = [
				'campaign_name' 					=> $params['txt_campaignName'],
				'campaign_status' 				=> $params['slc_campaignStatus'],
				'product' 								=> $params['txt_product'],
				'expected_close_date' 		=> $params['txt_expectedCloseDate'],
				'target_size' 						=> $params['txt_targetSize'],
				'campaign_type' 					=> $params['slc_campaignType'],
				'target_audience' 				=> $params['txt_targetAudience'],
				'sponsor' 								=> $params['txt_sponsor'],
				'num_sent' 								=> $params['txt_numSent'],
				'assigned_to' 						=> $params['slc_assignedTo'],
				'budget_cost' 						=> $params['txt_budgetCost'],
				'expected_response' 			=> $params['txt_expectedResponse'],
				'expected_sales_count' 		=> $params['txt_expectedSalesCount'],
				'expected_response_count' => $params['txt_expectedResponseCount'],
				'expected_roi' 						=> $params['txt_expectedROI'],
				'actual_cost' 						=> $params['txt_actualCost'],
				'expected_revenue' 				=> $params['txt_expectedRevenue'],
				'actual_sales_count' 			=> $params['txt_actualSalesCount'],
				'actual_response_count' 	=> $params['txt_actualResponseCount'],
				'actual_roi' 							=> $params['txt_actualROI'],
				'campaign_description' 		=> $params['txt_description'],
				'created_by' 							=> $this->session->userdata('arkonorllc_user_id'),
				'created_date' 						=> date('Y-m-d H:i:s')
			];

			$result = $this->campaigns->addCampaign($arrData);
			$msgResult = ($result > 0)? "Success" : "Database error";
		}
		else
		{
		  $msgResult = strip_tags(validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectCampaign()
	{
		$params = getParams();

		$data = $this->campaigns->selectCampaign($params['campaignId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function editCampaign()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_campaignName', 'Campaign Name', 'required');
		$this->form_validation->set_rules('slc_assignedTo', 'Assigned To', 'required');
		$this->form_validation->set_rules('txt_expectedCloseDate', 'Expected Close Date', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$arrData = [
				'campaign_name' 					=> $params['txt_campaignName'],
				'campaign_status' 				=> $params['slc_campaignStatus'],
				'product' 								=> $params['txt_product'],
				'expected_close_date' 		=> $params['txt_expectedCloseDate'],
				'target_size' 						=> $params['txt_targetSize'],
				'campaign_type' 					=> $params['slc_campaignType'],
				'target_audience' 				=> $params['txt_targetAudience'],
				'sponsor' 								=> $params['txt_sponsor'],
				'num_sent' 								=> $params['txt_numSent'],
				'assigned_to' 						=> $params['slc_assignedTo'],
				'budget_cost' 						=> $params['txt_budgetCost'],
				'expected_response' 			=> $params['txt_expectedResponse'],
				'expected_sales_count' 		=> $params['txt_expectedSalesCount'],
				'expected_response_count' => $params['txt_expectedResponseCount'],
				'expected_roi' 						=> $params['txt_expectedROI'],
				'actual_cost' 						=> $params['txt_actualCost'],
				'expected_revenue' 				=> $params['txt_expectedRevenue'],
				'actual_sales_count' 			=> $params['txt_actualSalesCount'],
				'actual_response_count' 	=> $params['txt_actualResponseCount'],
				'actual_roi' 							=> $params['txt_actualROI'],
				'campaign_description' 		=> $params['txt_description'],
				'updated_by' 			=> $this->session->userdata('arkonorllc_user_id')
			];

			$result = $this->campaigns->editCampaign($arrData, $params['txt_campaignId']);
			$msgResult = ($result > 0)? "Success" : "Database error";
		}
		else
		{
		  $msgResult = strip_tags(validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadCampaignDetails()
	{
		$params = getParams();

		$data = $this->campaigns->loadCampaignDetails($params['campaignId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadSelectedContactCampaigns()
	{
		$params = getParams();

		$data = $this->campaigns->loadSelectedContactCampaigns($params['campaignId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadUnlinkContacts()
	{
		$params = getParams();

		$arrData = $this->campaigns->loadContactCampaigns($params['campaignId']);

		$arrContactIds = [];
		foreach($arrData as $key => $value)
		{
			$arrContactIds[] = $value['contact_id']; 
		}

		$data = $this->contacts->loadUnlinkContacts($arrContactIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadSelectedOrganizationCampaigns()
	{
		$params = getParams();

		$data = $this->campaigns->loadSelectedOrganizationCampaigns($params['campaignId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadUnlinkOrganizations()
	{
		$params = getParams();

		$arrData = $this->campaigns->loadOrganizationCampaigns($params['campaignId']);

		$arrOrganizationIds = [];
		foreach($arrData as $key => $value)
		{
			$arrOrganizationIds[] = $value['organization_id']; 
		}

		$data = $this->organizations->loadUnlinkOrganizations($arrOrganizationIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}