<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('common_helper');
		$this->load->helper('url');
		$this->load->library('SliceLibrary',null,'slice');

		$this->load->database();
	}

	public function index()
	{
		echo json_encode(decrypt_code('AwcsaaLsE6DXQ5Z2tbpOHA=='));
	}

	public function sampleEmail()
	{
		$params = getParams();

		// $arr = explode("_",$params['summernote']);

		$data = [
			'__first_name__' => 'Juan',
			'__last_name__' => 'Tamad'
		];

		$arr = $params['summernote'];

		foreach ($data as $key => $value) 
		{
			$arr = str_ireplace($key,$value,$arr);
			// $arr = $key;
		}

		echo json_encode($arr);
	}

}