<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organizations extends CI_Model 
{
	/*
		OrganizationController->loadOrganizations()
	*/
	public function loadOrganizations()
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

		$this->db->select($columns);
		$this->db->from('organizations');
		$data = $this->db->get()->result();
    return $data;
	}

	/*
		OrganizationController->addOrganization()
	*/
	public function addOrganization($arrData)
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
	public function selectOrganization($organizationId)
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

		$this->db->where('id',$organizationId);
		$this->db->select($columns);
		$this->db->from('organizations');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		OrganizationController->loadOrganizationContacts()
	*/
	public function loadOrganizationContacts($organizationId)
	{
		$columns = [
			'a.id',
			'a.salutation',
			'a.first_name',
			'a.last_name',
			'a.position',
			'a.organization_id',
			'(SELECT organization_name FROM organizations WHERE id = a.organization_id) as organization_name',
			'a.primary_email',
			'a.created_by',
			'a.created_date'
		];

		$this->db->where('a.organization_id',$organizationId);
		$this->db->select($columns);
		$this->db->from('contacts a');
		$this->db->order_by('a.id','desc');
		$data = $this->db->get()->result();
    return $data;
	}

	/*
		OrganizationController->unlinkOrganizationContact()
	*/
	public function unlinkOrganizationContact($contactId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update('contacts',['organization_id'=>null],['id'=>$contactId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		OrganizationController->loadOrganizationEmails()
	*/
	public function loadOrganizationEmails($organizationId)
	{
		$columns = [
			'a.id',
			'a.email_subject',
			'a.email_content',
			'a.email_status',
			'(SELECT organization_name FROM organizations WHERE id = a.sent_to) as sent_to_name',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.sent_by) as sent_by_name',
			'DATE_FORMAT(A.created_date, "%Y-%m-%d") as date_sent',
			'DATE_FORMAT(A.created_date, "%H:%i:%s") as time_sent'
		];

		$this->db->where('a.sent_to',$organizationId);
		$this->db->select($columns);
		$this->db->from('organization_email_histories a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		OrganizationController->addOrganizationCampaign()
	*/
	public function addOrganizationCampaign($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert_batch('organization_campaigns',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		OrganizationController->unlinkOrganizationCampaign()
	*/
	public function unlinkOrganizationCampaign($organizationCampaignId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->delete('organization_campaigns',['id'=>$organizationCampaignId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		CampaignController->loadUnlinkOrganizations()
	*/
	public function loadUnlinkOrganizations($arrOrganizationIds)
	{
		$columns = [
			'a.id',
			'a.organization_name',
			'a.primary_email',
			'a.main_website',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name'
		];

		if(count($arrOrganizationIds) > 0)
		{
			$this->db->where_not_in('a.id',$arrOrganizationIds);
		}

		$this->db->select($columns);
		$this->db->from('organizations a');
		$data = $this->db->get()->result_array();
    return $data;
	}


}