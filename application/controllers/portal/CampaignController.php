<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');

class CampaignController extends CI_Controller
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
		$this->load->model('portal/Campaigns','campaigns');
		$this->load->model('portal/Contacts','contacts');
		$this->load->model('portal/Organizations','organizations');
	}

	public function loadCampaigns()
	{
		$data = $this->campaigns->loadCampaigns();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}