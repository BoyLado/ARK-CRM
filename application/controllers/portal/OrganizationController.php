<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class OrganizationController extends CI_Controller
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
		$this->load->model('portal/Organizations','organizations');
		$this->load->model('portal/EmailTemplates','email_template');
	}

	public function loadOrganizations()
	{
		$data = $this->organizations->loadOrganizations();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addOrganization()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_organizationName', 'Organization Name', 'required');
		$this->form_validation->set_rules('txt_primaryEmail', 'Primary Email', 'required');
		$this->form_validation->set_rules('slc_assignedTo', 'Assigned To', 'required');

    if ($this->form_validation->run() == TRUE)
    {
    	$arrData = [
    		'organization_name' 		=> $params['txt_organizationName'],
    		'primary_email' 		=> $params['txt_primaryEmail'],
    		'assigned_to' 		=> $params['slc_assignedTo'],
    		'created_by' 		=> $this->session->userdata('arkonorllc_user_id'),
    		'created_date'	=> date('Y-m-d H:i:s')
    	];

    	$result = $this->organizations->addOrganization($arrData);
    	$msgResult = ($result > 0)? "Success" : "Database error";
    }
    else
    {
      $msgResult = strip_tags(validation_errors());
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectOrganization()
	{
		$params = getParams();

		$data = $this->organizations->selectOrganization($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}