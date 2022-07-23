<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class EmailTemplateController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('SliceLibrary',null,'slice');

		if(!$this->session->has_userdata('arkonorllc_user_id'))
		{
		  redirect(base_url(),'refresh');
		}

		$this->load->database();
		$this->load->model('portal/EmailTemplates','email_template');
	}

	public function loadCategories()
	{
		$data = $this->email_template->loadCategories();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addCategory()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_categoryName', 'Category Name', 'required');
		if ($this->form_validation->run() == TRUE)
    {
    	$arrData = [
    		'category_name' => $params['txt_categoryName'],
    		'category_description' => $params['txt_categoryDescription'],
    		'created_by' 	=> $this->session->userdata('arkonorllc_user_id'),
				'created_date'	=> date('Y-m-d H:i:s')
    	];
    	$result = $this->email_template->addCategory($arrData);
    	$msgResult = ($result > 0)? "Success" : "Error! <br>Database error.";
    }
    else
    {
    	$msgResult = strip_tags(validation_errors());
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadTemplates()
	{
		$data = $this->email_template->loadTemplates();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addTemplate()
	{
		$params = getParams();

		$this->form_validation->set_rules('slc_category', 'Category Name', 'required');
		$this->form_validation->set_rules('txt_templateName', 'Template Name', 'required');
		$this->form_validation->set_rules('slc_templateVisibility', 'Accessibility', 'required');
		$this->form_validation->set_rules('txt_subject', 'Subject', 'required');
		$this->form_validation->set_rules('txt_content', 'Content', 'required');
		if ($this->form_validation->run() == TRUE)
    {
    	$arrData = [
    		'category_id' => $params['slc_category'],
    		'template_name' => $params['txt_templateName'],
    		'template_description' => $params['txt_description'],
    		'template_subject' => $params['txt_subject'],
    		'template_content' => $params['txt_content'],
    		'template_visibility' => $params['slc_templateVisibility'],
    		'template_status' => "1",
    		'created_by' 	=> $this->session->userdata('arkonorllc_user_id'),
				'created_date'	=> date('Y-m-d H:i:s')
    	];
    	$result = $this->email_template->addTemplate($arrData);
    	$msgResult = ($result > 0)? "Success" : "Error! <br>Database error.";
    }
    else
    {
    	$msgResult = strip_tags(validation_errors());
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectTemplate()
	{
		$params = getParams();
		$data = $this->email_template->selectTemplate($params['templateId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}