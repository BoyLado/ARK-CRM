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


}