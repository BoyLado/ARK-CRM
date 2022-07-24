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
			'a.unsubscribe_auth_code',
			'a.assigned_to',
			'a.created_by',
			'a.created_date'
		];

		$this->db->where('id',$contactId);
		$this->db->select($columns);
		$this->db->from('contacts a');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		ContactController->selectContactSummary()
	*/
	public function selectContactSummary($contactId)
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

	public function selectContactDetails($contactId)
	{
		$columns = [
			'a.id',
			'a.salutation',
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
		$this->db->join('contact_description_details c','a.id = c.contact_id','left');
		$data = $this->db->get()->row_array();
    return $data;
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