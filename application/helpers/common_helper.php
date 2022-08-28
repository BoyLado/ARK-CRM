<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function dayTime($start)
{
  if($start == null || $start == '')
  {
    return "No date found!";
  }
  date_default_timezone_set('Asia/Manila');

  $start = strtotime($start);
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

  return $days . " day(s) & " . $hours . " hour(s)";
}


function set_filename($filename,$path = './assets/uploads/')
	{

		$x = explode('.', $filename);

		if (count($x) === 1)
		{
			return '';
		}

		$ext = '.'.strtolower(end($x));

		$filename = preg_replace('/\s+/', '_', $filename);

		if (! file_exists($path.$filename))
		{
			return $filename;
		}

		$filename = str_replace($ext, '', $filename);
		

		$new_filename = '';
		for ($i = 1; $i < 1000; $i++)
		{
			if ( ! file_exists($path.$filename.$i.$ext))
			{
				$new_filename = $filename.$i.$ext;
				break;
			}
		}

		return $new_filename;
	}

function do_upload($filename, $uploadPath = './assets/uploads/')
{
	$CI =& get_instance();
	$config['upload_path']          = $uploadPath;
	$config['allowed_types']        = '*';
	$config['max_size']             = 5000;
	// $config['max_width']            = 1000;
	// $config['max_height']           = 667;
	$config['encrypt_name'] 				= TRUE;

	$CI->load->library('upload', $config);

	if ( ! $CI->upload->do_upload($filename))
	{
			$msgResult['error'] = $CI->upload->display_errors();
	}
	else
	{
			$msgResult['upload_data'] = $CI->upload->data();
			$msgResult['success'] = "success";

	}
	
	return $msgResult;
}

function do_multiple_upload($params)
{
	$CI =& get_instance();
	// Count total files
	$countfiles 				= count($params['name']);
	$error 							= '';
	$params['name'] 		= array_values($params['name']);
	$params['type'] 		= array_values($params['type']);
	$params['tmp_name'] = array_values($params['tmp_name']);
	$params['error'] 		= array_values($params['error']);
	$params['size'] 		= array_values($params['size']);
	
	for($i=0;$i<$countfiles;$i++)
	{
		if(!empty($params['name'][$i]))
		{
			$config['upload_path']      = './assets/uploads/';
			$config['allowed_types']    = '*';
			$config['max_size']         = 5000;
			$_FILES['file']['name'] 		= $params['name'][$i];
			$_FILES['file']['type'] 		= $params['type'][$i];
			$_FILES['file']['tmp_name'] = $params['tmp_name'][$i];
			$_FILES['file']['error'] 		= $params['error'][$i];
			$_FILES['file']['size'] 		= $params['size'][$i];

			//Load upload library
			$CI->load->library('upload',$config); 

			// File upload
			if ( ! $CI->upload->do_upload('file'))
			{
				$error = $CI->upload->display_errors();					
			}
			else
			{					
				$data = array('upload_data' => $CI->upload->data());
				$error = "";
			}
		}
	}
	return $error;
}

/*
|----------------------------------------------------------------------
| Loading of Pdf Report
|----------------------------------------------------------------------
| Must set the orientation, papersize, filename, and the format
| 
|
*/

function loadPdfReport($data,$orientation,$paperSize,$fileName,$download = 'false'){
		$path = $_SERVER['DOCUMENT_ROOT'].'pdfReports/'; //Prod Mode
		// $path = $_SERVER['DOCUMENT_ROOT'].'/mmc/pdfReports/'; //Dev Mode
		$CI =& get_instance();
		if($orientation == 'portrait'){
			$message = $CI->load->view('backend/template/pdfReport/portrait/mainReport',$data,true);
		}else{
			$message = $CI->load->view('backend/template/pdfReport/landscape/mainReportL',$data,true);
		}

		if($download != 'false'){
			$CI->pdf->set_option('enable_html5_parser', TRUE);
			$CI->pdf->set_option('isHtml5ParserEnabled', TRUE);
			$CI->pdf->loadHtml($message);   
			$CI->pdf->setPaper($paperSize,$orientation); 
			$CI->pdf->render();
			$pdf = $CI->pdf->output();
			$file_location = $path.$fileName.".pdf";
			file_put_contents($file_location,$pdf);
		}else{

			$CI->pdf->set_option("isPhpEnabled", true);
			$CI->pdf->loadHtml($message);
			$CI->pdf->setPaper($paperSize,$orientation);
			$CI->pdf->render();
			$CI->pdf->stream($fileName."'.pdf", array('Attachment'=>0));

		}
	}

function fileSizeValidation($file){
		$error = '';	
		if($file != ''){
			
			$image_info = getimagesize($file);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
		
			if($image_width != 1080 && $image_height != 1080){
				$error = 'Image size must 1080x1080';
			}
		}
		// width 1080
		// height 1080

		return $error;
		
}


function do_resize($filename){
	$CI =& get_instance();
	$configResize['image_library'] = 'gd2';
	$configResize['source_image'] = './uploads/'.$filename;
	$configResize['maintain_ratio'] = FALSE;
	$configResize['create_thumb']  = FALSE;
	$configResize['width']         = 1024;
	$configResize['height']        = 786;
	$configResize['new_image']     = './uploads/'.$filename;

	$CI->load->library('image_lib',$configResize);
	$CI->image_lib->resize();
}

/*
|----------------------------------------------------------------------
| Getting Params
|----------------------------------------------------------------------
| Getting Parameters from Get, Post and Files
| returned as array
|
*/

function getParams($xss = TRUE)
{
	$CI =& get_instance();
	$get = $CI->input->get(NULL, $xss) ? $CI->input->get(NULL, $xss) : array();
	$post = $CI->input->post(NULL, $xss) ? $CI->input->post(NULL, $xss) : array();
	$params = array_merge(array_merge($get, $post), $_FILES);

	return $params;
}

/*
|----------------------------------------------------------------------
| Sending Email
|----------------------------------------------------------------------
| Used to send e-mail
|
*/

function sendMail($senderEmail,$receiverEmail,$subject,$body,$headers=''){
	$CI =& get_instance();
	$CI->load->library('email');
	//SMTP & mail configuration
	$config = array(
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.gmail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'captivatemailserver@gmail.com', 
		'smtp_pass' => '##Captivategrp123*',
		'mailtype' => 'html', 
		'charset' => 'iso-8859-1'
	);

	$CI->email->initialize($config);
	$CI->email->set_mailtype("html");
	$CI->email->set_newline("\r\n");

	$CI->email->from('captivatemailserver@gmail.com');
	$CI->email->to($receiverEmail);
	$CI->email->subject($subject);
	$message = "<html><body>";
	$message .= $body;
	$message .= "</body></html>";
	$CI->email->message($message);
	$CI->email->send();
}

function sendSliceMail($type,$senderEmail,$receiverEmail,&$data)
{
	$config = [
		'protocol' 	=> 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'ajhay.dev@gmail.com',
		'smtp_pass' => 'moznmnthwmdefziy',
		'mailtype'  => 'html', 
		'charset'   => 'iso-8859-1'
	];

	$CI =& get_instance();
	$CI->load->library('SliceLibrary',null,'slice');
	$CI->load->library('email');
	$CI->lang->load('arkonorllc');

	$CI->email->initialize($config);
	$CI->email->set_newline("\r\n");

	$CI->email->from($senderEmail);
	$CI->email->to($receiverEmail);
	$CI->email->subject(sprintf($CI->lang->line('arkonorllc_'.$type), $data['subjectTitle']));
	$CI->email->message($CI->slice->view('email.'.$type.'_html', $data, TRUE));
	$CI->email->set_alt_message($CI->slice->view('email.'.$type.'_txt', $data, TRUE));
	$result = $CI->email->send();
	return $result;
}

function generate_code()
{
	$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 10);
	return $code;
}


function encrypt_code($decrypted_code)
{
  $sSalt = 'abcdefghijklmnopqrstvwxyz0123456789';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $result = base64_encode(openssl_encrypt($decrypted_code, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
    
    return $result;
}

function decrypt_code($encrypted_code)
{
    $sSalt = 'abcdefghijklmnopqrstvwxyz0123456789';
    $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
    $method = 'aes-256-cbc';

    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

    $result = openssl_decrypt(base64_decode($encrypted_code), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
    
    return $result;
}

function load_substitutions($arrData, $emailTemplate)
{
	foreach ($arrData as $key => $value) 
	{
		$emailTemplate = str_ireplace($key,$value,$emailTemplate);
	}

	return $emailTemplate;
}
