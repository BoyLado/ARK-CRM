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
		$this->load->model('portal/EmailTemplates','email_template');
		$this->load->model('portal/Documents','documents');
		$this->load->model('portal/Campaigns','campaigns');
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

		$this->form_validation->set_rules('txt_lastName', 'Last Name', 'required');
		$this->form_validation->set_rules('slc_assignedTo', 'Assigned To', 'required');

		if ($this->form_validation->run() == TRUE)
		{	
			$msgResult = 0;

			$arrData = [
				'salutation' 			=> $params['slc_salutation'],
				'first_name' 			=> $params['txt_firstName'],
				'last_name' 			=> $params['txt_lastName'],
				'position' 				=> $params['txt_position'],
				'organization_id'	=> ($params['slc_companyName'] == "")? NULL : $params['slc_companyName'],
				'primary_email' 	=> $params['txt_primaryEmail'],
				'secondary_email' => $params['txt_secondaryEmail'],
				'date_of_birth'		=> $params['txt_birthDate'],
				'intro_letter'		=> $params['slc_introLetter'],
				'office_phone'		=> $params['txt_officePhone'],
				'mobile_phone'		=> $params['txt_mobilePhone'],
				'home_phone'			=> $params['txt_homePhone'],
				'secondary_phone'	=> $params['txt_secondaryPhone'],
				'fax'							=> $params['txt_fax'],
				'do_not_call'			=> $params['chk_doNotCall'],
				'linkedin_url'		=> $params['txt_linkedinUrl'],
				'twitter_url'			=> $params['txt_twitterUrl'],
				'facebook_url'		=> $params['txt_facebookUrl'],
				'instagram_url'		=> $params['txt_instagramUrl'],
				'lead_source'			=> $params['slc_leadSource'],
				'department'			=> $params['txt_department'],
				'reports_to'			=> ($params['slc_reportsTo'] == "")? NULL : $params['slc_reportsTo'],
				'assigned_to'			=> ($params['slc_assignedTo'] == "")? NULL : $params['slc_assignedTo'],
				'email_opt_out'		=> $params['slc_emailOptOut'],
				'unsubscribe_auth_code' => encrypt_code(generate_code()),
				'created_by' 			=> $this->session->userdata('arkonorllc_user_id'),
				'created_date'		=> date('Y-m-d H:i:s')
			];

			$insertId = $this->contacts->addContact($arrData);
			if($insertId != 0)
			{
				$arrAddressData = [
					'contact_id' 			=> $insertId,
					'mailing_street' 	=> $params['txt_mailingStreet'],
					'mailing_po_box' 	=> $params['txt_mailingPOBox'],
					'mailing_city' 		=> $params['txt_mailingCity'],
					'mailing_state' 	=> $params['txt_mailingState'],
					'mailing_zip' 		=> $params['txt_mailingZip'],
					'mailing_country' => $params['txt_mailingCountry'],
					'other_street' 		=> $params['txt_otherStreet'],
					'other_po_box' 		=> $params['txt_otherPOBox'],
					'other_city' 			=> $params['txt_otherCity'],
					'other_state' 		=> $params['txt_otherState'],
					'other_zip' 			=> $params['txt_otherZip'],
					'other_country' 	=> $params['txt_otherCountry'],
					'created_by' 			=> $this->session->userdata('arkonorllc_user_id'),
					'created_date'		=> date('Y-m-d H:i:s')
				];
				$arrDescriptionData = [
					'contact_id' 			=> $insertId,
					'description' 		=> $params['txt_description'],
					'created_by' 			=> $this->session->userdata('arkonorllc_user_id'),
					'created_date'		=> date('Y-m-d H:i:s')
				];

				$result = $this->contacts->addContactDetails($arrAddressData, $arrDescriptionData);
				$msgResult = ($result > 0)? "Success" : "Database error";
			}
		}
		else
		{
		  $msgResult = strip_tags(validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectContact()
	{
		$params = getParams();

		$data = $this->contacts->selectContact($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function editContact()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_lastName', 'Last Name', 'required');
		$this->form_validation->set_rules('slc_assignedTo', 'Assigned To', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$arrData['contact_details'] = [
				'salutation' 			=> $params['slc_salutation'],
				'first_name' 			=> $params['txt_firstName'],
				'last_name' 			=> $params['txt_lastName'],
				'position' 				=> $params['txt_position'],
				'organization_id'	=> $params['slc_companyName'],
				'primary_email' 	=> $params['txt_primaryEmail'],
				'secondary_email' => $params['txt_secondaryEmail'],
				'date_of_birth'		=> $params['txt_birthDate'],
				'intro_letter'		=> $params['slc_introLetter'],
				'office_phone'		=> $params['txt_officePhone'],
				'mobile_phone'		=> $params['txt_mobilePhone'],
				'home_phone'			=> $params['txt_homePhone'],
				'secondary_phone'	=> $params['txt_secondaryPhone'],
				'fax'							=> $params['txt_fax'],
				'do_not_call'			=> $params['chk_doNotCall'],
				'linkedin_url'		=> $params['txt_linkedinUrl'],
				'twitter_url'			=> $params['txt_twitterUrl'],
				'facebook_url'		=> $params['txt_facebookUrl'],
				'instagram_url'		=> $params['txt_instagramUrl'],
				'lead_source'			=> $params['slc_leadSource'],
				'department'			=> $params['txt_department'],
				'reports_to'			=> $params['slc_reportsTo'],
				'assigned_to'			=> $params['slc_assignedTo'],
				'email_opt_out'		=> $params['slc_emailOptOut'],
				'updated_by' 			=> $this->session->userdata('arkonorllc_user_id')
			];

			$arrData['contact_address'] = [
				'mailing_street' 	=> $params['txt_mailingStreet'],
				'mailing_po_box' 	=> $params['txt_mailingPOBox'],
				'mailing_city' 		=> $params['txt_mailingCity'],
				'mailing_state' 	=> $params['txt_mailingState'],
				'mailing_zip' 		=> $params['txt_mailingZip'],
				'mailing_country' => $params['txt_mailingCountry'],
				'other_street' 		=> $params['txt_otherStreet'],
				'other_po_box' 		=> $params['txt_otherPOBox'],
				'other_city' 			=> $params['txt_otherCity'],
				'other_state' 		=> $params['txt_otherState'],
				'other_zip' 			=> $params['txt_otherZip'],
				'other_country' 	=> $params['txt_otherCountry'],
				'updated_by' 			=> $this->session->userdata('arkonorllc_user_id')
			];

			$arrData['contact_description'] = [
				'description' 		=> $params['txt_description'],
				'updated_by' 			=> $this->session->userdata('arkonorllc_user_id')
			];

			$result = $this->contacts->editContact($arrData, $params['txt_contactId']);
			$msgResult = ($result > 0)? "Success" : "Database error";
		}
		else
		{
		  $msgResult = strip_tags(validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadContactSummary()
	{
		$params = getParams();

		$data = $this->contacts->loadContactSummary($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadContactDetails()
	{
		$params = getParams();

		$data = $this->contacts->loadContactDetails($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function loadContactEmails()
	{
		$params = getParams();

		$data = $this->contacts->loadContactEmails($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}











	// contact documents

	public function loadContactDocuments()
	{
		$params = getParams();

		$data = $this->contacts->loadContactDocuments($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function unlinkContactDocument()
	{
		$params = getParams();

		$result = $this->contacts->unlinkContactDocument($params['contactDocumentId']);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadUnlinkContactDocuments()
	{
		$params = getParams();

		$arrData = $this->contacts->loadContactDocuments($params['contactId']);

		$arrDocumentIds = [];
		foreach($arrData as $key => $value)
		{
			$arrDocumentIds[] = $value['document_id']; 
		}

		$data = $this->documents->loadUnlinkDocuments($arrDocumentIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addSelectedContactDocuments()
	{
		$params = getParams();

		$arrData = [];
		if(isset($params['arrSelectedDocuments']))
		{
			foreach(explode(',',$params['arrSelectedDocuments']) as $key => $value)
			{
				$arrData[] = ['contact_id'=>$params['contactId'], 'document_id'=>$value];
			}
		}
		else
		{
			foreach(explode(',',$params['arrSelectedContacts']) as $key => $value)
			{
				$arrData[] = ['contact_id'=>$value, 'document_id'=>$params['documentId']];
			}
		}

		$result = $this->contacts->addSelectedContactDocuments($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function addContactDocument()
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
					'contact_id' => $params['txt_contactId'],
					'document_id' => $documentId,
					'created_by'  => $this->session->userdata('arkonorllc_user_id'),
					'created_date'=> date('Y-m-d H:i:s')
				];

				$result = $this->contacts->addContactDocument($arrData);
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












	//contact campaign
	public function loadContactCampaigns()
	{
		$params = getParams();

		$data = $this->contacts->loadContactCampaigns($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function unlinkContactCampaign()
	{
		$params = getParams();

		$result = $this->contacts->unlinkContactCampaign($params['contactCampaignId']);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadUnlinkContactCampaigns()
	{
		$params = getParams();

		$arrData = $this->contacts->loadContactCampaigns($params['contactId']);

		$arrCampaignIds = [];
		foreach($arrData as $key => $value)
		{
			$arrCampaignIds[] = $value['campaign_id']; 
		}

		$data = $this->campaigns->loadUnlinkContactCampaigns($arrCampaignIds);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addSelectedContactCampaigns()
	{
		$params = getParams();

		$arrData = [];
		if(isset($params['arrSelectedCampaigns']))
		{
			foreach(explode(',',$params['arrSelectedCampaigns']) as $key => $value)
			{
				$arrData[] = ['contact_id'=>$params['contactId'], 'campaign_id'=>$value];
			}
		}
		else
		{
			foreach(explode(',',$params['arrSelectedContacts']) as $key => $value)
			{
				$arrData[] = ['contact_id'=>$value, 'campaign_id'=>$params['campaignId']];
			}
		}

		$result = $this->contacts->addSelectedContactCampaigns($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}
	










	//contact comments

	public function loadContactComments()
	{
		$params = getParams();

		$data = $this->contacts->loadContactComments($params['contactId']);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function addContactComment()
	{
		$params = getParams();

		$arrData = [
			'contact_id' 		=> $params['txt_contactId'],
			'comment_id' 		=> NULL,
			'comment' 			=> $params['txt_comments'],
			'comment_index' => $params['txt_commentIndex'],
			'created_by' 		=> $this->session->userdata('arkonorllc_user_id'),
			'created_date' 	=> date('Y-m-d H:i:s')
		];
		$result = $this->contacts->addContactComment($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
	}

	public function selectEmailTemplate()
	{
		$params = getParams();

		$templateData = $this->email_template->selectTemplate($params['templateId']);

		$data = $templateData;

		$contactData = $this->contacts->selectContact($params['contactId']);

		foreach ($contactData as $key => $value) 
		{
			$newContactData['__'.$key.'__'] = $value; 
		}	

		$data['template_subject'] = load_substitutions($newContactData, $templateData['template_subject']);
		$data['template_content'] = load_substitutions($newContactData, $templateData['template_content']);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function sendContactEmail()
	{
		$params = getParams();

		$emailSender 		= 'ajhay.work@gmail.com';
		$emailReceiver  = $params['txt_to'];

		$arrData = $this->contacts->selectContact($params['txt_contactId']);

		$data['subjectTitle'] = $params['txt_subject'];
		$data['emailContent'] = $params['txt_content'];
		$unsubscribeLink = "contact-unsubscribe/".$params['txt_contactId']."/".decrypt_code($arrData['unsubscribe_auth_code'])."/".$params['txt_to'];
		$data['unsubscribeLink'] = (isset($params['chk_unsubscribe']))? $unsubscribeLink : "";

		$emailResult = sendSliceMail('contact_email',$emailSender,$emailReceiver,$data);

		$arrData = [];
		if($emailResult == 1)
		{
			$arrData = [
				'email_subject' => $params['txt_subject'],
				'email_content' => $params['txt_content'],
				'email_status' 	=> 'Sent',
				'sent_to' 			=> $params['txt_contactId'],
				'sent_by'				=> $this->session->userdata('arkonorllc_user_id'),
				'created_date'  => date('Y-m-d H:i:s')
			];
		}
		else
		{
			$arrData = [
				'email_subject' => $params['txt_subject'],
				'email_content' => $params['txt_content'],
				'email_status' 	=> 'Not sent',
				'sent_to' 			=> $params['txt_contactId'],
				'sent_by'				=> $this->session->userdata('arkonorllc_user_id'),
				'created_date'  => date('Y-m-d H:i:s')
			];
		}

		$result = $this->contacts->saveContactEmails($arrData);
		$msgResult = ($result > 0)? "Success" : "Database Error";

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}


}