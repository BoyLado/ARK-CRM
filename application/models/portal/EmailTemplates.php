<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailTemplates extends CI_Model 
{
	/*
		EmailTemplateController->loadCategories()
	*/
	public function loadCategories()
	{
		$columns = [
			'id',
			'category_name',
			'category_description',
			'created_by',
			'created_date'
		];

		$this->db->select($columns);
		$this->db->from('email_template_categories');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		EmailTemplateController->addCategory()
	*/
	public function addCategory($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('email_template_categories',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		EmailTemplateController->loadTemplates()
	*/
	public function loadTemplates()
	{
		$columns = [
			'a.id',
			'(SELECT category_name FROM email_template_categories WHERE id = a.category_id) as category_name',
			'a.template_name',
			'a.template_description',
			'a.template_subject',
			'a.template_content',
			'a.template_visibility',
			'a.template_status',
			'(SELECT CONCAT(first_name) FROM users WHERE id = a.created_by) as created_by',
			'a.created_date'
		];

		$this->db->select($columns);
		$this->db->from('email_templates a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		EmailTemplateController->addTemplate()
	*/
	public function addTemplate($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('email_templates',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	/*
		EmailTemplateController->selectTemplate()
		ContactController->selectEmailTemplate()
		OrganizationController->selectEmailTemplate()
	*/
	public function selectTemplate($templateId)
	{
		$columns = [
			'a.id',
			'(SELECT category_name FROM email_template_categories WHERE id = a.category_id) as category_name',
			'a.template_name',
			'a.template_description',
			'a.template_subject',
			'a.template_content',
			'a.template_visibility',
			'a.template_status',
			'(SELECT CONCAT(first_name) FROM users WHERE id = a.created_by) as created_by',
			'a.created_date'
		];

		$this->db->where('a.id',$templateId);
		$this->db->select($columns);
		$this->db->from('email_templates a');
		$data = $this->db->get()->row_array();
    return $data;
	}
}