<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class IndexController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('portal/Users','user');
	}

	public function login()
	{
		$params = getParams();

    $this->form_validation->set_rules('txt_userEmail', 'Email Address', 'trim|valid_email');
    $this->form_validation->set_rules('txt_userPassword', 'Password', 'required');

    if ($this->form_validation->run() == TRUE)
    {
      $logInRequirements = [
        'user_email' 			=> $params['txt_userEmail'],
        'user_password' 	=> encrypt_code($params['txt_userPassword']),
        'user_auth_code'	=> encrypt_code($params['txt_userAuthCode']),
        'user_status' 		=> '1', //meaning active
      ];

      $validateLogInResult = $this->user->validateLogIn($logInRequirements);

      if(!empty($validateLogInResult))
      {
        $userData = [
          'arkonorllc_user_id' 				=> $validateLogInResult['user_id'],
          'arkonorllc_user_firstName' => $validateLogInResult['first_name'],
          'arkonorllc_user_lastName' 	=> $validateLogInResult['last_name']
        ];
        $this->session->set_userdata($userData);

        $msgResult = "Success";
      }
      else
      {
        $msgResult = "Access denied, please try again or contact our administrator";
      }
    }
    else
    {
      $msgResult = strip_tags(validation_errors());
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

	public function forgotPassword()
	{
		$params = getParams();

		$this->form_validation->set_rules('txt_userEmail', 'Email Address', 'trim|valid_email');

		if ($this->form_validation->run() == TRUE)
    {    	
    	$arrData = [
    		'password_auth_code' => encrypt_code(generate_code())
    	];
    	$result = $this->user->createPasswordAuthCode($arrData, $params['txt_userEmail']);
    	if($result > 0)
    	{
    		$emailSender 		= 'ajhay.work@gmail.com';
    		$emailReceiver  = $params['txt_userEmail'];

    		$arrResult = $this->user->loadUser(['user_email'=>$emailReceiver]);

    		$data['subjectTitle'] = 'Forgot Password';
        $data['userId'] = $arrResult['user_id'];
    		$data['userName'] = $arrResult['first_name'] . " " . $arrResult['last_name'];
        $data['userAuthCode'] = decrypt_code($arrResult['user_auth_code']);
    		$data['passwordAuthCode'] = decrypt_code($arrResult['password_auth_code']);

    		$emailResult = sendSliceMail('forgot_password',$emailSender,$emailReceiver,$data);
    		$msgResult = ($emailResult == 1)? "Success" : $emailResult;
    	}
    	else
    	{
    		$msgResult = "Error! <br>Your email was not recognized!";
    	}    	
    }
    else
    {
      $msgResult = strip_tags(validation_errors());
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
	}

  public function changePassword()
  {
    $params = getParams();

    $this->form_validation->set_rules('txt_newPassword', 'New Password', 'required');
    $this->form_validation->set_rules('txt_confirmPassword', 'Confirm Password', 'required');

    if ($this->form_validation->run() == TRUE)
    {
      $arrData = [
        'user_password' => encrypt_code($params['txt_newPassword'])
      ];

      $whereParams = [
        'id' => $params['txt_userId'],
        'password_auth_code' => encrypt_code($params['txt_passwordAuthCode'])
      ];

      $result = $this->user->changePassword($arrData, $whereParams);
      $msgResult = ($result == 1)? "Success" : "Database error";
    }
    else
    {
      $msgResult = strip_tags(validation_errors());
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
  }

  public function signUp()
  {
    $params = getParams();

    $this->form_validation->set_rules('txt_firstName', 'First Name', 'required');
    $this->form_validation->set_rules('txt_userEmail', 'Email Address', 'trim|valid_email');
    $this->form_validation->set_rules('txt_userPassword', 'Password', 'required');

    if ($this->form_validation->run() == TRUE)
    {
      $arrData = [
        'first_name'    => $params['txt_firstName'],
        'last_name'     => $params['txt_lastName'],
        'user_email'    => $params['txt_userEmail'],
        'user_password' => encrypt_code($params['txt_userPassword']),
        'user_status'    => '1'
      ];

      $whereParams = [
        'id' => $params['txt_userId'],
        'user_auth_code' => encrypt_code($params['txt_userAuthCode']),
        'user_status' => '0'
      ];

      $result = $this->user->signUp($arrData, $whereParams);
      $msgResult = ($result == 1)? "Success" : "Database error";
    }
    else
    {
      $msgResult = strip_tags(validation_errors());
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($msgResult));
  }

  public function logout()
  {
    $userData = [
      'arkonorllc_user_id',
      'arkonorllc_user_firstName',
      'arkonorllc_user_lastName'
    ];
    $this->session->unset_userdata($userData);
    redirect(base_url(),'refresh');
  }

}