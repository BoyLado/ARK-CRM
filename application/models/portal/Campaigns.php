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
			'id',
			'campaign_name',
			'campaign_type',
			'created_by',
			'created_date'
		];

		$this->db->select($columns);
		$this->db->from('campaigns');
		$data = $this->db->get()->result();
    return $data;
	}

	/*
		OrganizationController->addOrganization()
	*/
	public function addCampaign($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('organizations',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		OrganizationController->selectOrganization()
		OrganizationController->selectEmailTemplate()
		NavigationController->organizationPreview($organizationId)
	*/
	public function selectCampaign($campaignId)
	{
		$columns = [
			'id',
			'organization_name',
			'primary_email',
			'main_website',
			'(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = assigned_to) assigned_to',
			'created_by',
			'created_date'
		];

		$this->db->where('id',$campaignId);
		$this->db->select($columns);
		$this->db->from('organizations');
		$data = $this->db->get()->row_array();
    return $data;
	}


}