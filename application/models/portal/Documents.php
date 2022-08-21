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
}