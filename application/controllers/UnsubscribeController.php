<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class UnsubscribeController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('SliceLibrary',null,'slice');

		$this->load->database();
		$this->load->model('portal/Contacts','contacts');
		$this->load->model('portal/EmailTemplates','email_template');
	}

	public function contactUnsubscribe($contactId, $authCode, $contactEmail)
	{
		$arrData = $this->contacts->verifyContact($contactId, encrypt_code($authCode));

		if($arrData != null && $contactEmail != false)
		{
			$emailSender 		= 'ajhay.dev@gmail.com';
			$emailReceiver  = $contactEmail;

			$data['subjectTitle'] = 'Unsubscribe Confirmation';
			$unsubscribeConfirmationLink = "contact-confirmation/".$contactId."/".$authCode."/".$contactEmail;
			$data['unsubscribeConfirmationLink'] = $unsubscribeConfirmationLink;

			$emailResult = sendSliceMail('unsubscribe_confirmation',$emailSender,$emailReceiver,$data);
			$msgResult = ($emailResult == 1)? "Success" : $emailResult;
		}
		else
		{
			$msgResult = "Error 401 Unauthorized!";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function contactConfirmation($contactId, $authCode, $contactEmail)
	{
		$arrData = $this->contacts->verifyContact($contactId, encrypt_code($authCode));

		if($arrData != null && $contactEmail != false)
		{
			$emailSender 		= 'ajhay.dev@gmail.com';
			$emailReceiver  = 'ajhay.work@gmail.com';

			$data['subjectTitle'] = 'Unsubscribe Notification';
			$data['contactName'] = $arrData['full_name'];
			$data['contactPosition'] = $arrData['position'];
			$data['contactEmail'] = $contactEmail;

			$emailResult = sendSliceMail('unsubscribe_notification',$emailSender,$emailReceiver,$data);

			if($emailResult == 1)
			{
				$arrData = ['email_opt_out'=>1];
				$result = $this->contacts->emailOptOut($contactId, $arrData);
			}
			else
			{
				$result = 0;
			}

			$msgResult = ($result > 0)? "Success" : "Database Error";
		}
		else
		{
			$msgResult = "Error 401 Unauthorized!";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

}