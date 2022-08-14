<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Model 
{
	/*
		ContactController->loadContact()
	*/
	public function loadContacts()
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

		$this->db->select($columns);
		$this->db->from('contacts a');
		$this->db->order_by('a.id','desc');
		$data = $this->db->get()->result();
    return $data;
	}

	/*
		ContactController->addContact()
	*/
	public function addContact($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('contacts',$arrData);
		    $insertId = $this->db->insert_id();
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? $insertId : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		ContactController->addContact()
	*/
	public function addContactDetails($arrAddressData, $arrDescriptionData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('contact_address_details',$arrAddressData);
		    $this->db->insert('contact_description_details',$arrDescriptionData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		ContactController->selectContact()
		ContactController->sendContactEmail()
		NavigationController->contactPreview($contactId)
	*/
	public function selectContact($contactId)
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
			'a.secondary_email',
			'a.date_of_birth',
			'a.intro_letter',
			'a.office_phone',
			'a.mobile_phone',
			'a.home_phone',
			'a.secondary_phone',
			'a.fax',
			'a.do_not_call',
			'a.linkedin_url',
			'a.twitter_url',
			'a.facebook_url',
			'a.instagram_url',
			'a.lead_source',
			'a.department',
			'a.reports_to',
			'a.assigned_to',
			'a.email_opt_out',
			'a.unsubscribe_auth_code',
			'a.created_by',
			'a.created_date',
			'b.mailing_street',
			'b.mailing_po_box',
			'b.mailing_city',
			'b.mailing_state',
			'b.mailing_zip',
			'b.mailing_country',
			'b.other_street',
			'b.other_po_box',
			'b.other_city',
			'b.other_state',
			'b.other_zip',
			'b.other_country',
			'c.description'
		];

		$this->db->where('a.id',$contactId);
		$this->db->select($columns);
		$this->db->from('contacts a');
		$this->db->join('contact_address_details b','a.id = b.contact_id','left');
		$this->db->join('contact_description_details c','a.id = c.contact_id','left');
		$data = $this->db->get()->row_array();
    return $data;
	}

	public function editContact($arrData, $contactId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update('contacts',$arrData['contact_details'],['id'=>$contactId]);
		    $this->db->update('contact_address_details',$arrData['contact_address'],['contact_id'=>$contactId]);
		    $this->db->update('contact_description_details',$arrData['contact_description'],['contact_id'=>$contactId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		ContactController->loadContactSummary()
	*/
	public function loadContactSummary($contactId)
	{
		$columns = [
			'a.id',
			'a.first_name',
			'a.last_name',
			'a.position',
			'a.organization_id',
			'(SELECT organization_name FROM organizations WHERE id = a.organization_id) as organization_name',
			'a.assigned_to',
			'(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to',
			'b.mailing_city',
			'b.mailing_country'
		];

		$this->db->where('a.id',$contactId);
		$this->db->select($columns);
		$this->db->from('contacts a');
		$this->db->join('contact_address_details b','a.id = b.contact_id','left');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		ContactController->loadContactDetails()
	*/
	public function loadContactDetails($contactId)
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
			'a.secondary_email',
			'a.date_of_birth',
			'a.intro_letter',
			'a.office_phone',
			'a.mobile_phone',
			'a.home_phone',
			'a.secondary_phone',
			'a.fax',
			'a.do_not_call',
			'a.linkedin_url',
			'a.twitter_url',
			'a.facebook_url',
			'a.instagram_url',
			'a.lead_source',
			'a.department',
			'a.reports_to',
			'(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.reports_to) as reports_to_name',
			'a.assigned_to',
			'(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'a.email_opt_out',
			'b.mailing_street',
			'b.mailing_po_box',
			'b.mailing_city',
			'b.mailing_state',
			'b.mailing_zip',
			'b.mailing_country',
			'b.other_street',
			'b.other_po_box',
			'b.other_city',
			'b.other_state',
			'b.other_zip',
			'b.other_country',
			'c.description'
		];

		$this->db->where('a.id',$contactId);
		$this->db->select($columns);
		$this->db->from('contacts a');
		$this->db->join('contact_address_details b','a.id = b.contact_id','left');
		$this->db->join('contact_description_details c','a.id = c.contact_id','left');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		ContactController->loadContactEmails()
	*/
	public function loadContactEmails($contactId)
	{
		$columns = [
			'a.id',
			'a.email_subject',
			'a.email_content',
			'a.email_status',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM contacts WHERE id = a.sent_to) as sent_to_name',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.sent_by) as sent_by_name',
			'DATE_FORMAT(A.created_date, "%Y-%m-%d") as date_sent',
			'DATE_FORMAT(A.created_date, "%H:%i:%s") as time_sent'
		];

		$this->db->where('a.sent_to',$contactId);
		$this->db->select($columns);
		$this->db->from('contact_email_histories a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->loadContactCampaigns()
	*/
	public function loadContactCampaigns($contactId)
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

		$this->db->where('a.contact_id',$contactId);
		$this->db->select($columns);
		$this->db->from('contact_campaigns a');
		$this->db->join('campaigns b','a.campaign_id = b.id','left');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->addContactCampaign()
	*/
	public function addContactCampaign($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert_batch('contact_campaigns',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		ContactController->unlinkContactCampaign()
	*/
	public function unlinkContactCampaign($contactCampaignId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->delete('contact_campaigns',['id'=>$contactCampaignId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		CampaignController->loadUnlinkContacts()
	*/
	public function loadUnlinkContacts($arrContactIds)
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
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name'
		];

		if(count($arrContactIds) > 0)
		{
			$this->db->where_not_in('a.id',$arrContactIds);
		}

		$this->db->select($columns);
		$this->db->from('contacts a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->loadContactComments()
	*/
	public function loadContactComments($contactId)
	{
		$columns = [
			'a.id',
			'a.contact_id',
			'a.comment_id',
			'a.comment',
			'a.comment_index',
			'a.created_by',
			'(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.created_by) as created_by_name',
			'a.created_date'
		];

		$this->db->where('a.contact_id',$contactId);
		$this->db->select($columns);
		$this->db->from('contact_comments a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->addContactComment()
	*/
	public function addContactComment($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('contact_comments',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}



	/*
		ContactController->sendContactEmail()
	*/
	public function saveContactEmails($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('contact_email_histories',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/* 
	=======================================================================>
	
		UnsubscribeController->contactUnsubscribe($contactId, $authCode)
	
	=======================================================================>
	*/

	public function verifyContact($contactId, $authCode)
	{
		$columns = [
			'a.id',
			'CONCAT(a.salutation," ",a.first_name," ",a.last_name) as full_name',
			'a.position',
			'a.organization_id',
			'a.primary_email',
			'(SELECT user_email FROM users WHERE id = a.reports_to) as reports_to',
			'a.unsubscribe_auth_code',
			'(SELECT user_email FROM users WHERE id = a.assigned_to) as assigned_to',
			'a.created_by',
			'a.created_date'
		];

		$where = [
			'a.id' => $contactId,
			'a.unsubscribe_auth_code' => $authCode
		];

		$this->db->where($where);
		$this->db->select($columns);
		$this->db->from('contacts a');
		$data = $this->db->get()->row_array();
    return $data;
	}

	public function emailOptOut($contactId, $arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update('contacts',$arrData,['id'=>$contactId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}













	//test insert user
	public function test($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('users',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	// test code for uploading pdf
	public function loadSample($id, $column)
	{
		$this->db->where(['id',$id]);
		$this->db->select($column);
		$this->db->from('users');
		$query = $this->db->get();
		$ret = $query->row_array();
		return $ret[$column];
	}

}