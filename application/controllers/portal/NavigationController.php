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

		if(!$this->session->has_userdata('arkonorllc_user_id'))
		{
		  redirect(base_url(),'refresh');
		}

		$this->load->database();
	}

	public function page404()
	{
		$data['pageTitle'] = "Arkonor LLC | 404 Page";
		$this->slice->view('404', $data);
	}

	public function dashboard()
	{
		$data['pageTitle'] = "Arkonor LLC | Dashboard";
		$this->slice->view('dashboard', $data);
	}

	public function contacts()
	{
		$data['pageTitle'] = "Arkonor LLC | Contacts";
		$data['customScripts'] = 'contacts';
		$this->slice->view('portal.contact', $data);
	}

	public function emailTemplate()
	{
		$data['pageTitle'] = "Arkonor LLC | Email Template";
		$data['customScripts'] = 'email_template';
		$this->slice->view('portal.tools.email_template', $data);
	}

	public function users()
	{
		$data['pageTitle'] = "Arkonor LLC | Users";
		$data['customScripts'] = 'users';
		$this->slice->view('portal.users', $data);
	}
	//place your navigation links here
}
