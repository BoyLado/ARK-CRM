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
			'id',
			'salutation',
			'first_name',
			'last_name',
			'primary_email',
			'created_by',
			'created_date'
		];

		$this->db->select($columns);
		$this->db->from('contacts');
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
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

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