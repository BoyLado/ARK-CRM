<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class ContactController extends CI_Controller
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
		$this->load->model('portal/Contacts','contacts');
	}

	// test code for uploading pdf
	public function uploadPdf()
	{
		$params = getParams();
		// $filename = $params['file_pdf'];
		$filename = do_upload('file_pdf');
		$this->output->set_content_type('application/json')->set_output(json_encode($filename));
	}

	public function loadSample()
	{
		$data = $this->contacts->loadSample(1,'last_name');
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadContacts()
	{
		$data = $this->contacts->loadContacts();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addContact()
	{
		$params = getParams();

		$arrData = [
			'salutation' 		=> $params['slc_salutation'],
			'first_name' 		=> $params['txt_firstName'],
			'last_name' 		=> $params['txt_lastName'],
			'primary_email' => $params['txt_primaryEmail'],
			'created_by' 		=> $this->session->userdata('arkonorllc_user_id'),
			'created_date'	=> date('Y-m-d H:i:s')
		];

		$result = $this->contacts->addContact($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}


}