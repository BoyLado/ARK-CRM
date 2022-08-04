<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class NavigationController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('SliceLibrary',null,'slice');

		$this->load->database();
	}

	public function index()
	{
		// $data['pageTitle'] = "Arkonor LLC | Sample Index";
		// $this->slice->view('sample', $data);
		$data['pageTitle'] = "Arkonor LLC | Login";
		$data['userAuthCode'] = "";
		$this->slice->view('login', $data);
	}

	public function dashboard()
	{
		$data['pageTitle'] = "Arkonor LLC | Dashboard";
		$this->slice->view('dashboard', $data);
	}

	public function page404()
	{
		$data['pageTitle'] = "Arkonor LLC | 404 Page";
		$this->slice->view('404', $data);
	}

	public function login()
	{
		$data['pageTitle'] = "Arkonor LLC | Login";
		$data['userAuthCode'] = "";
		$this->slice->view('login', $data);
	}

	public function loginWithAuth($userAuthCode)
	{
		$data['pageTitle'] = "Arkonor LLC | Login";
		$data['userAuthCode'] = $userAuthCode;
		$this->slice->view('login', $data);
	}

	public function forgotPassword()
	{
		$data['pageTitle'] = "Arkonor LLC | Forgot Password";
		$this->slice->view('forgot_password', $data);
	}

	public function changePassword($userId, $userAuthCode, $passwordAuthCode)
	{
		$data['pageTitle'] = "Arkonor LLC | Change Password";
		$data['userId'] = $userId;
		$data['userAuthCode'] = $userAuthCode;
		$data['passwordAuthCode'] = $passwordAuthCode;
		$this->slice->view('change_password', $data);
	}

	public function signUp($userId, $userAuthCode)
	{
		$data['pageTitle'] = "Arkonor LLC | Sign Up";
		$data['userId'] = $userId;
		$data['userAuthCode'] = $userAuthCode;
		$this->slice->view('sign_up', $data);
	}

	//place your navigation links here
}
