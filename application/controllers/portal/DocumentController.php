<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class DocumentController extends CI_Controller
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
		$this->load->model('portal/Organizations','organizations');
		$this->load->model('portal/Documents','documents');
		$this->load->model('portal/EmailTemplates','email_template');
	}

	public function loadDocuments()
	{
		$data = $this->documents->loadDocuments();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addDocument()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_title', 'Campaign Name', 'required');
		$this->form_validation->set_rules('slc_assignedToDocument', 'Assigned To', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			if($params['slc_uploadtype'] == 2)
			{
				$arrData = [
					'title' 					=> $params['txt_title'],
					'type' 						=> $params['slc_uploadtype'],
					'file_url' 				=> $params['txt_fileUrl'],
					'notes' 					=> $params['txt_notes'],
					'assigned_to' 		=> $params['slc_assignedToDocument'],
					'created_by' 			=> $this->session->userdata('arkonorllc_user_id'),
					'created_date' 		=> date('Y-m-d H:i:s')
				];
			}
			else
			{

			}			

			$result = $this->documents->addDocument($arrData);
			$msgResult = ($result > 0)? "Success" : "Database error";
		}
		else
		{
		  $msgResult = strip_tags(validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectDocument()
	{
		$params = getParams();

		$documentId = $params['documentId'];

		$data = $this->documents->selectDocument($documentId);
		$data['uploadLast'] = dayTime($data['created_date']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}








	public function loadSelectedContactDocuments()
	{
		$params = getParams();

		$data = $this->documents->loadSelectedContactDocuments($params['documentId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadUnlinkContacts()
	{
		$params = getParams();

		$arrData = $this->documents->loadContactDocuments($params['documentId']);

		$arrContactIds = [];
		foreach($arrData as $key => $value)
		{
			$arrContactIds[] = $value['contact_id']; 
		}

		$data = $this->contacts->loadUnlinkContacts($arrContactIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	







	
	public function loadSelectedOrganizationDocuments()
	{
		$params = getParams();

		$data = $this->documents->loadSelectedOrganizationDocuments($params['documentId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadUnlinkOrganizations()
	{
		$params = getParams();

		$arrData = $this->documents->loadOrganizationDocuments($params['documentId']);

		$arrOrganizationIds = [];
		foreach($arrData as $key => $value)
		{
			$arrOrganizationIds[] = $value['organization_id']; 
		}

		$data = $this->organizations->loadUnlinkOrganizations($arrOrganizationIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}