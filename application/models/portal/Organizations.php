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
		    $insertId = $this->db->insert_id();
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? $insertId : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		OrganizationController->addOrganization()
	*/
	public function addOrganizationDetails($arrAddressData, $arrDescriptionData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('organization_address_details',$arrAddressData);
		    $this->db->insert('organization_description_details',$arrDescriptionData);
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
			'a.id',
			'a.organization_name',
			'a.primary_email',
			'a.secondary_email',
			'a.main_website',
			'a.other_website',
			'a.phone_number',
			'a.fax',
			'a.linkedin_url',
			'a.facebook_url',
			'a.twitter_url',
			'a.instagram_url',
			'a.industry',
			'a.naics_code',
			'a.employee_count',
			'a.annual_revenue',
			'a.type',
			'a.ticket_symbol',
			'a.member_of',
			'a.email_opt_out',
			'a.assigned_to',
			'(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
			'a.created_by',
			'a.created_date',
			'b.billing_street',
			'b.billing_city',
			'b.billing_state',
			'b.billing_zip',
			'b.billing_country',
			'b.shipping_street',
			'b.shipping_city',
			'b.shipping_state',
			'b.shipping_zip',
			'b.shipping_country',
			'c.description'
		];

		$this->db->where('a.id',$organizationId);
		$this->db->select($columns);
		$this->db->from('organizations a');
		$this->db->join('organization_address_details b','a.id = b.organization_id','left');
		$this->db->join('organization_description_details c','a.id = c.organization_id','left');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		OrganizationController->editOrganization()
	*/
	public function editOrganization($arrData, $organizationId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update('organizations',$arrData['organization_details'],['id'=>$organizationId]);
		    $this->db->update('organization_address_details',$arrData['organization_address'],['organization_id'=>$organizationId]);
		    $this->db->update('organization_description_details',$arrData['organization_description'],['organization_id'=>$organizationId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}











	/*
		OrganizationController->loadOrganizationSummary()
	*/
	public function loadOrganizationSummary($organizationId)
	{
		$columns = [
			'a.id',
			'a.organization_name',
			'(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'b.billing_city',
			'b.billing_country'
		];

		$this->db->where('a.id',$organizationId);
		$this->db->select($columns);
		$this->db->from('organizations a');
		$this->db->join('organization_address_details b','a.id = b.organization_id','left');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		OrganizationController->loadOrganizationDetails()
	*/
	public function loadOrganizationDetails($organizationId)
	{
		$columns = [
			'a.id',
			'a.organization_name',
			'a.primary_email',
			'a.secondary_email',
			'a.main_website',
			'a.other_website',
			'a.phone_number',
			'a.fax',
			'a.linkedin_url',
			'a.facebook_url',
			'a.twitter_url',
			'a.instagram_url',
			'a.industry',
			'a.naics_code',
			'a.employee_count',
			'a.annual_revenue',
			'a.type',
			'a.ticket_symbol',
			'a.member_of',
			'a.email_opt_out',
			'a.assigned_to',
			'(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'b.billing_street',
			'b.billing_city',
			'b.billing_state',
			'b.billing_zip',
			'b.billing_country',
			'b.shipping_street',
			'b.shipping_city',
			'b.shipping_state',
			'b.shipping_zip',
			'b.shipping_country',
			'c.description'
		];

		$this->db->where('a.id',$organizationId);
		$this->db->select($columns);
		$this->db->from('organizations a');
		$this->db->join('organization_address_details b','a.id = b.organization_id','left');
		$this->db->join('organization_description_details c','a.id = c.organization_id','left');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		OrganizationController->loadOrganizationContacts()
		OrganizationController->loadUnlinkOrganizationContacts()
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
		$data = $this->db->get()->result_array();
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
		OrganizationController->addSelectedOrganizationContacts()
	*/
	public function addSelectedOrganizationContacts($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update_batch('contacts',$arrData,'id');
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
		OrganizationController->loadOrganizationDocuments()
	*/
	public function loadOrganizationDocuments($organizationId)
	{
		$columns = [
			'a.id',
			'a.document_id',
			'b.title',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
			'b.document_number',
			'b.type',
			'b.file_name',
			'b.file_url',
			'b.file_type',
			'b.file_size',
			'b.download_count',
			'b.created_date',
			'b.updated_date'
		];

		$this->db->where('a.organization_id',$organizationId);
		$this->db->select($columns);
		$this->db->from('organization_documents a');
		$this->db->join('documents b','a.document_id = b.id','left');
		$data = $this->db->get()->result_array();
	  return $data;
	}

	/*
		OrganizationController->unlinkOrganizationDocument()
	*/
	public function unlinkOrganizationDocument($organizationDocumentId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->delete('organization_documents',['id'=>$organizationDocumentId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		OrganizationController->addSelectedOrganizationDocuments()
	*/
	public function addSelectedOrganizationDocuments($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert_batch('organization_documents',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		OrganizationController->addOrganizationDocument()
	*/
	public function addOrganizationDocument($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('organization_documents',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}









	/*
		OrganizationController->loadOrganizationCampaigns()
	*/
	public function loadOrganizationCampaigns($organizationId)
	{
		$columns = [
			'a.id',
			'a.campaign_id',
			'b.campaign_name',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
			'b.campaign_status',
			'b.campaign_type',
			'b.expected_close_date',
			'b.expected_revenue'
		];

		$this->db->where('a.organization_id',$organizationId);
		$this->db->select($columns);
		$this->db->from('organization_campaigns a');
		$this->db->join('campaigns b','a.campaign_id = b.id','left');
		$data = $this->db->get()->result_array();
    return $data;
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
		OrganizationController->addSelectedOrganizationCampaigns()
	*/
	public function addSelectedOrganizationCampaigns($arrData)
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
		CampaignController->loadUnlinkOrganizations()
		DocumentController->loadUnlinkOrganizations()
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