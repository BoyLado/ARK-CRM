<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$data['pageTitle'] = "Arkonor LLC | Sample Index";
		$this->slice->view('sample', $data);
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
		$data['authCode'] = "";
		$this->slice->view('login', $data);
	}

	public function loginWithAuth($authCode)
	{
		$data['pageTitle'] = "Arkonor LLC | Login";
		$data['authCode'] = $authCode;
		$this->slice->view('login', $data);
	}

	public function forgotPassword()
	{
		$data['pageTitle'] = "Arkonor LLC | Forgot Password";
		$this->slice->view('forgot_password', $data);
	}

	public function changePassword($authCode)
	{
		$data['pageTitle'] = "Arkonor LLC | Change Password";
		$data['authCode'] = $authCode;
		$this->slice->view('change_password', $data);
	}

	//place your navigation links here
}
