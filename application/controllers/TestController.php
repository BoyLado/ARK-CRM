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
		echo json_encode(encrypt_code('123456789'));
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

	public function sampleTime()
	{
		// $hour1 = 0; $hour2 = 0;
		// $date1 = "2014-05-27 01:00:00";
		// $date2 = "2014-05-28 02:00:00";
		// $datetimeObj1 = new DateTime($date1);
		// $datetimeObj2 = new DateTime($date2);
		// $interval = $datetimeObj1->diff($datetimeObj2);
		 
		// if($interval->format('%a') > 0){
		// $hour1 = $interval->format('%a')*24;
		// }
		// if($interval->format('%h') > 0){
		// $hour2 = $interval->format('%h');
		// }
		 
		// echo "Difference between two dates is " . ($hour1 + $hour2) . " hours.";

		// $date1 = "2014-05-27 01:00:00";
		// $date2 = "2014-05-28 02:00:00";
		// $timestamp1 = strtotime($date1);
		// $timestamp2 = strtotime($date2);
		// $hour = abs($timestamp2 - $timestamp1)/(60*60);
		// // echo "Difference between two dates is " . $hour = abs($timestamp2 - $timestamp1)/(60*60) . " hour(s)";
		
		// $days = (($hour / 24) > 0)? intval($hour / 24) . " day(s) " : 0;

		// $hours = (($hour % 24) > 0)? intval($hour % 24) . " hour(s)" : 0;

		// // echo $days . $hours;

		// echo $this->sumDays($days);
		date_default_timezone_set('Asia/Manila');

		$start = strtotime('2022-07-13 00:00:00');
		$end = strtotime(date('Y-m-d H:i:s'));
		$days = 0;
		$hours = 0;
		while(date('Y-m-d H:i:s', $start) < date('Y-m-d H:i:s', $end)){
			$dayDiff = (abs($end - $start)/(60*60)) / 24;
			if($dayDiff >= 1)
			{
				$days += date('N', $start) < 6 ? 1 : 0;
			}
		  $hours = date('N', $start) < 6 ? (abs($end - $start)/(60*60)) % 24 : 0;
		  $start = strtotime("+1 day", $start);
		}
		echo $days . " day(s) & " . $hours . " hour(s)";
		echo date('Y-m-d H:i:s');

	}

	function sumDays($days = 0, $format = 'd/m/Y') {
	    $incrementing = $days > 0;
	    $days         = abs($days);
	    $actualDate   = date('Y-m-d');

	    while ($days > 0) {
	        $tsDate    = strtotime($actualDate . ' ' . ($incrementing ? '+' : '-') . ' 1 days');
	        $actualDate = date('Y-m-d', $tsDate);

	        if (date('N', $tsDate) < 6) {
	            $days--;
	        }
	    }

	    return date($format, strtotime($actualDate));
	}

}