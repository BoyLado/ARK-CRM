<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class TaskController extends CI_Controller
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
		$this->load->model('portal/Tasks','tasks');
		
	}

	
	public function addTask()
	{
		$params = getParams();

		$arrData = [
			'subject' 			=> $params['txt_taskSubject'],
			'assigned_to' 	=> $params['slc_taskAssignedTo'],
			'start_date' 		=> $params['txt_taskStartDate'],
			'start_time'		=> $params['txt_taskStartTime'],
			'end_date'			=> $params['txt_taskEndDate'],
			'end_time'			=> $params['txt_taskEndTime'],
			'status'				=> $params['slc_taskStatus'],
			'created_by'		=> $this->session->userdata('arkonorllc_user_id'),
			'created_date'	=> date('Y-m-d H:i:s') 
		];

		$result = $this->tasks->addTask($arrData);
		$msgResult = ($result > 0)? "Success" : "Database error";
		$this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function selectTask()
	{

	}

	public function editTask()
	{
		
	}

}