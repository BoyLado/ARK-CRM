<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class CalendarController extends CI_Controller
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
		$this->load->model('portal/Calendars','calendars');
		$this->load->model('portal/Events','events');
		$this->load->model('portal/Tasks','tasks');
		
	}

	//
	//Calendars
	//
	public function loadCalendars()
	{
		$arrData['arrCalendars'] = $this->calendars->loadCalendars();
		$arrData['arrEvents'] = $this->events->loadEvents();
		$arrData['arrTasks'] = $this->tasks->loadTasks();
		$this->output->set_content_type('application/json')->set_output(json_encode($arrData));
	}

	public function addCalendar()
	{
		$params = getParams();

		$arrData = [
			'calendar_name' => $params['txt_calendarName'],
			'timezone' 			=> $params['slc_timezone'],
			'created_by'		=> $this->session->userdata('arkonorllc_user_id'),
			'created_date'	=> date('Y-m-d H:i:s')
		];

		$result = $this->calendars->addCalendar($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectCalendar()
	{

	}

	public function editCalendar()
	{

	}

	public function removeCalendar()
	{

	}




}