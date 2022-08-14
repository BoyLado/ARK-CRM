<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaigns extends CI_Model 
{
	/*
		CampaignController->loadCampaigns()
	*/
	public function loadCampaigns()
	{
		$columns = [
			'a.id',
			'a.campaign_name',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'a.campaign_status',
			'a.campaign_type',
			'a.expected_close_date',
			'a.expected_revenue',
			'a.created_by',
			'a.created_date'
		];

		$this->db->select($columns);
		$this->db->from('campaigns a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		CampaignController->addCampaign()
	*/
	public function addCampaign($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('campaigns',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		CampaignController->selectCampaign()
	*/
	public function selectCampaign($campaignId)
	{
		$columns = [
			'a.id',
			'a.campaign_name',
			'a.campaign_status',
			'a.product',
			'a.expected_close_date',
			'a.target_size',
			'a.campaign_type',
			'a.target_audience',
			'a.sponsor',
			'a.num_sent',
			'a.assigned_to',
			'a.budget_cost',
			'a.expected_response',
			'a.expected_sales_count',
			'a.expected_response_count',
			'a.expected_roi',
			'a.actual_cost',
			'a.expected_revenue',
			'a.actual_sales_count',
			'a.actual_response_count',
			'a.actual_roi',
			'a.campaign_description',
			'(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
			'a.created_by',
			'a.created_date'
		];

		$this->db->where('a.id',$campaignId);
		$this->db->select($columns);
		$this->db->from('campaigns a');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		CampaignController->editCampaign()
	*/
	public function editCampaign($arrData, $campaignId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update('campaigns',$arrData,['id'=>$campaignId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		CampaignController->loadCampaignDetails()
	*/
	public function loadCampaignDetails($campaignId)
	{
		$columns = [
			'a.id',
			'a.campaign_name',
			'a.campaign_status',
			'a.product',
			'a.expected_close_date',
			'a.target_size',
			'a.campaign_type',
			'a.target_audience',
			'a.sponsor',
			'a.num_sent',
			'a.assigned_to',
			'a.budget_cost',
			'a.expected_response',
			'a.expected_sales_count',
			'a.expected_response_count',
			'a.expected_roi',
			'a.actual_cost',
			'a.expected_revenue',
			'a.actual_sales_count',
			'a.actual_response_count',
			'a.actual_roi',
			'a.campaign_description',
			'(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
			'a.created_by',
			'a.created_date',
			'a.updated_by',
			'a.updated_date'
		];

		$this->db->where('a.id',$campaignId);
		$this->db->select($columns);
		$this->db->from('campaigns a');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		CampaignController->loadSelectedContactCampaigns()
	*/
	public function loadSelectedContactCampaigns($campaignId)
	{
		$columns = [
			'a.id',
			'a.campaign_id',
			'a.contact_id',
			'b.salutation',
			'b.first_name',
			'b.last_name',
			'b.office_phone',
			'b.primary_email',
			'b.position',
			'b.organization_id',
			'(SELECT organization_name FROM organizations WHERE id = b.organization_id) as organization_name',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
			'c.mailing_city',
			'c.mailing_country'
		];

		$this->db->where('a.campaign_id',$campaignId);
		$this->db->select($columns);
		$this->db->from('contact_campaigns a');
		$this->db->join('contacts b','a.contact_id = b.id','left');
		$this->db->join('contact_address_details c','c.contact_id = b.id','left');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->loadUnlinkContactCampaigns()
	*/
	public function loadUnlinkContactCampaigns($arrCampaignIds)
	{
		$columns = [
			'a.id',
			'a.campaign_name',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'a.campaign_status',
			'a.campaign_type',
			'a.expected_close_date',
			'a.expected_revenue',
			'a.created_by',
			'a.created_date'
		];

		if(count($arrCampaignIds) > 0)
		{
			$this->db->where_not_in('a.id',$arrCampaignIds);
		}

		$this->db->select($columns);
		$this->db->from('campaigns a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		CampaignController->loadUnlinkContacts()
	*/
	public function loadContactCampaigns($campaignId)
	{
		$columns = [
			'a.id',
			'a.contact_id'
		];

		$this->db->where('a.campaign_id',$campaignId);
		$this->db->select($columns);
		$this->db->from('contact_campaigns a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		CampaignController->loadSelectedOrganizationCampaigns()
	*/
	public function loadSelectedOrganizationCampaigns($campaignId)
	{
		$columns = [
			'a.id',
			'a.campaign_id',
			'a.organization_id',
			'b.organization_name',
			'b.primary_email',
			'b.main_website',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name'
		];

		$this->db->where('a.campaign_id',$campaignId);
		$this->db->select($columns);
		$this->db->from('organization_campaigns a');
		$this->db->join('organizations b','a.organization_id = b.id','left');
		$this->db->join('organization_address_details c','c.organization_id = b.id','left');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		CampaignController->loadUnlinkOrganizations()
	*/
	public function loadOrganizationCampaigns($campaignId)
	{
		$columns = [
			'a.id',
			'a.organization_id'
		];

		$this->db->where('a.campaign_id',$campaignId);
		$this->db->select($columns);
		$this->db->from('organization_campaigns a');
		$data = $this->db->get()->result_array();
    return $data;
	}

}