<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class EventController extends CI_Controller
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
		$this->load->model('portal/Events','events');
		
	}


	public function addEvent()
	{
		$params = getParams();		

		$arrData = [
			'subject' 			=> $params['txt_eventSubject'],
			'assigned_to' 	=> $params['slc_eventAssignedTo'],
			'start_date' 		=> $params['txt_eventStartDate'],
			'start_time'		=> $params['txt_eventStartTime'],
			'end_date'			=> $params['txt_eventEndDate'],
			'end_time'			=> $params['txt_eventEndTime'],
			'status'				=> $params['slc_eventStatus'],
			'type'					=> $params['slc_eventType'],
			'created_by'		=> $this->session->userdata('arkonorllc_user_id'),
			'created_date'	=> date('Y-m-d H:i:s') 
		];

		$result = $this->events->addEvent($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectEvent()
	{

	}

	public function editEvent()
	{

	}


}