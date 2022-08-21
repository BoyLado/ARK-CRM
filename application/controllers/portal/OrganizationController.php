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
		$this->load->model('portal/Documents','documents');
		$this->load->model('portal/Campaigns','campaigns');
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

	public function loadOrganizationSummary()
	{
		$params = getParams();

		$data = $this->organizations->loadOrganizationSummary($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadOrganizationDetails()
	{
		$params = getParams();

		$data = $this->organizations->loadOrganizationDetails($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadOrganizationContacts()
	{
		$params = getParams();

		$data = $this->organizations->loadOrganizationContacts($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function unlinkOrganizationContact()
	{
		$params = getParams();

		$result = $this->organizations->unlinkOrganizationContact($params['contactId']);
		$msgResult = ($result > 0)? "Success" : "Database error";

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadOrganizationEmails()
	{
		$params = getParams();

		$data = $this->organizations->loadOrganizationEmails($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadOrganizationDocuments()
	{
		$params = getParams();

		$data = $this->organizations->loadOrganizationDocuments($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function unlinkOrganizationDocument()
	{
		$params = getParams();

		$result = $this->organizations->unlinkOrganizationDocument($params['organizationDocumentId']);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadUnlinkOrganizationDocuments()
	{
		$params = getParams();

		$arrData = $this->organizations->loadOrganizationDocuments($params['organizationId']);

		$arrDocumentIds = [];
		foreach($arrData as $key => $value)
		{
			$arrDocumentIds[] = $value['document_id']; 
		}

		$data = $this->documents->loadUnlinkDocuments($arrDocumentIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addSelectedOrganizationDocuments()
	{
		$params = getParams();

		$arrData = [];
		if(isset($params['arrSelectedDocuments']))
		{
			foreach(explode(',',$params['arrSelectedDocuments']) as $key => $value)
			{
				$arrData[] = ['organization_id'=>$params['organizationId'], 'document_id'=>$value];
			}
		}
		else
		{
			foreach(explode(',',$params['arrSelectedContacts']) as $key => $value)
			{
				$arrData[] = ['organization_id'=>$value, 'document_id'=>$params['documentId']];
			}
		}

		$result = $this->organizations->addSelectedOrganizationDocuments($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function addOrganizationDocument()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_title', 'Title', 'required');
		$this->form_validation->set_rules('slc_assignedToDocument', 'Assigned To', 'required');

		if ($this->form_validation->run() == TRUE)
		{			
			$arrData = [
				'title' 			=> $params['txt_title'],
				'assigned_to' => $params['slc_assignedToDocument'],
				'type' 				=> $params['slc_type'],
				'notes'				=> $params['txt_notes'],
				'created_by'  => $this->session->userdata('arkonorllc_user_id'),
				'created_date'=> date('Y-m-d H:i:s')
			];
			if($params['slc_type'] == 1)
			{
				$arrData['file_name'] = '';
			}
			else
			{
				$arrData['file_url'] = $params['txt_fileUrl'];
			}

			$documentId = $this->documents->addDocument($arrData);
			if($documentId > 0)
			{
				$arrData = [
					'organization_id' => $params['txt_organizationId'],
					'document_id' => $documentId,
					'created_by'  => $this->session->userdata('arkonorllc_user_id'),
					'created_date'=> date('Y-m-d H:i:s')
				];

				$result = $this->organizations->addOrganizationDocument($arrData);
				$msgResult = ($result > 0)? "Success" : "Database error";
			}
			else
			{
				$msgResult = "Unable to save the document";
			}
		}
		else
		{
		  $msgResult = strip_tags(validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadOrganizationCampaigns()
	{
		$params = getParams();

		$data = $this->organizations->loadOrganizationCampaigns($params['organizationId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadUnlinkOrganizationCampaigns()
	{
		$params = getParams();

		$arrData = $this->organizations->loadOrganizationCampaigns($params['organizationId']);

		$arrCampaignIds = [];
		foreach($arrData as $key => $value)
		{
			$arrCampaignIds[] = $value['campaign_id']; 
		}

		$data = $this->campaigns->loadUnlinkOrganizationCampaigns($arrCampaignIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addOrganizationCampaign()
	{
		$params = getParams();

		$arrData = [];
		if(isset($params['arrSelectedCampaigns']))
		{
			foreach(explode(',',$params['arrSelectedCampaigns']) as $key => $value)
			{
				$arrData[] = ['organization_id'=>$params['organizationId'], 'campaign_id'=>$value];
			}
		}
		else
		{
			foreach(explode(',',$params['arrSelectedOrganizations']) as $key => $value)
			{
				$arrData[] = ['organization_id'=>$value, 'campaign_id'=>$params['campaignId']];
			}
		}

		$result = $this->organizations->addOrganizationCampaign($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function unlinkOrganizationCampaign()
	{
		$params = getParams();

		$result = $this->organizations->unlinkOrganizationCampaign($params['organizationCampaignId']);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectEmailTemplate()
	{
		$params = getParams();

		$templateData = $this->email_template->selectTemplate($params['templateId']);

		$data = $templateData;

		$contactData = $this->organizations->selectOrganization($params['organizationId']);

		foreach ($contactData as $key => $value) 
		{
			$newContactData['__'.$key.'__'] = $value; 
		}	

		$data['template_subject'] = load_substitutions($newContactData, $templateData['template_subject']);
		$data['template_content'] = load_substitutions($newContactData, $templateData['template_content']);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}