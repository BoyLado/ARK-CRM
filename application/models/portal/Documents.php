<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Model 
{
	/*
		DocumentController->loadDocuments()
	*/
	public function loadDocuments()
	{
		$columns = [
			'a.id',
			'a.title',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'a.document_number',
			'a.type',
			'a.file_name',
			'a.file_url',
			'a.file_type',
			'a.file_size',
			'a.download_count',
			'a.created_date',
			'a.updated_date'
		];

		$this->db->select($columns);
		$this->db->from('documents a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->loadUnlinkContactDocuments()
		OrganizationController->loadUnlinkContactDocuments()
	*/
	public function loadUnlinkDocuments($arrDocumentIds)
	{
		$columns = [
			'a.id',
			'a.title',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'a.document_number',
			'a.type',
			'a.file_name',
			'a.file_url',
			'a.file_type',
			'a.file_size',
			'a.download_count',
			'a.created_date',
			'a.updated_date'
		];

		if(count($arrDocumentIds) > 0)
		{
			$this->db->where_not_in('a.id',$arrDocumentIds);
		}

		$this->db->select($columns);
		$this->db->from('documents a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		ContactController->addContactDocument()
		OrganizationController->addOrganizationDocument()
		DocumentController->addDocument()
	*/
	public function addDocument($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('documents',$arrData);
		    $documentId = $this->db->insert_id();
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? $documentId : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		DocumentController->selectDocument()
	*/
	public function selectDocument($documentId)
	{
		$columns = [
			'a.id',
			'a.title',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
			'a.document_number',
			'a.type',
			'a.file_name',
			'a.file_url',
			'a.file_type',
			'a.file_size',
			'a.notes',
			'a.download_count',
			'a.created_date',
			'a.updated_date'
		];

		$this->db->where('a.id',$documentId);
		$this->db->select($columns);
		$this->db->from('documents a');
		$data = $this->db->get()->row_array();
    return $data;
	}

	/*
		DocumentController->loadSelectedContactDocuments()
	*/
	public function loadSelectedContactDocuments($documentId)
	{
		$columns = [
			'a.id',
			'a.document_id',
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

		$this->db->where('a.document_id',$documentId);
		$this->db->select($columns);
		$this->db->from('contact_documents a');
		$this->db->join('contacts b','a.contact_id = b.id','left');
		$this->db->join('contact_address_details c','c.contact_id = b.id','left');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		DocumentController->loadUnlinkContacts()
	*/
	public function loadContactDocuments($documentId)
	{
		$columns = [
			'a.id',
			'a.contact_id'
		];

		$this->db->where('a.document_id',$documentId);
		$this->db->select($columns);
		$this->db->from('contact_documents a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		DocumentController->loadSelectedOrganizationDocuments()
	*/
	public function loadSelectedOrganizationDocuments($documentId)
	{
		$columns = [
			'a.id',
			'a.document_id',
			'a.organization_id',
			'b.organization_name',
			'b.primary_email',
			'b.main_website',
			'(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name'
		];

		$this->db->where('a.document_id',$documentId);
		$this->db->select($columns);
		$this->db->from('organization_documents a');
		$this->db->join('organizations b','a.organization_id = b.id','left');
		$this->db->join('organization_address_details c','c.organization_id = b.id','left');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		DocumentController->loadUnlinkOrganizations()
	*/
	public function loadOrganizationDocuments($documentId)
	{
		$columns = [
			'a.id',
			'a.organization_id'
		];

		$this->db->where('a.document_id',$documentId);
		$this->db->select($columns);
		$this->db->from('organization_documents a');
		$data = $this->db->get()->result_array();
    return $data;
	}

}