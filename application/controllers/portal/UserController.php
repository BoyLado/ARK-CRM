<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class UserController extends CI_Controller
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
		$this->load->model('portal/Users','user');
	}

	public function test()
	{
		$result = $this->user->loadUser(['user_email'=>"ajhay.dev@gmail."]);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function loadPendingInvites()
	{
		$whereParams = ['user_status' => '0'];
		$arrResult = $this->user->loadUsers($whereParams);
		$this->output->set_content_type('application/json')->set_output(json_encode($arrResult));
	}

	public function inviteNewUser()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_userEmail', 'User Email', 'required');
		if ($this->form_validation->run() == TRUE)
    {
    	$arrData = [
    		'user_email' => $params['txt_userEmail'],
    		'user_auth_code' => encrypt_code(generate_code()),
    		'user_status' 	=> '0',
				'created_date'	=> date('Y-m-d H:i:s')
    	];
    	$result = $this->user->loadUser(['user_email'=>$params['txt_userEmail']]);
    	if($result == null)
    	{
    		$result = $this->user->inviteNewUser($arrData);
    		if($result > 0)
    		{
    			$emailSender 		= 'ajhay.work@gmail.com';
    			$emailReceiver  = $params['txt_userEmail'];

    			$arrResult = $this->user->loadUser(['user_email'=>$emailReceiver]);

    			$data['subjectTitle'] = 'Invite New User';
    			$data['userId'] = $arrResult['user_id'];
    			$data['userAuthCode'] = decrypt_code($arrResult['user_auth_code']);

    			$emailResult = sendSliceMail('invite_user',$emailSender,$emailReceiver,$data);
    			$msgResult = ($emailResult == 1)? "Success" : $emailResult;
    		}
    		else
    		{
    			$msgResult = "Error! <br>Database error!";
    		}
    	}
    	else
    	{
    		$msgResult = "Error! <br>Email already exist!";
    	}
    }
    else
    {
    	$msgResult = strip_tags(validation_errors());
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function loadUsers()
	{
		$whereParams = ['user_status' => '1'];
		$arrResult = $this->user->loadUsers($whereParams);
		$this->output->set_content_type('application/json')->set_output(json_encode($arrResult));
	}

	// public function test()
	// {
	// 	$arrData = [
	// 		'salutation' 		=> 'Mr.',
	// 		'first_name' 		=> 'Juan',
	// 		'last_name' 		=> 'Dela Cruz',
	// 		'user_email' 		=> 'ajhay.dev@gmail.com',
	// 		'user_password' => encrypt_code('Admin@123'),
	// 		'user_auth_code'=> encrypt_code('123456789'),
	// 		'user_status' 	=> '1',
	// 		'created_date'	=> date('Y-m-d H:i:s')
	// 	];

	// 	$result = $this->user->test($arrData);
	// 	$this->output->set_content_type('application/json')->set_output(json_encode($result));
	// }

}