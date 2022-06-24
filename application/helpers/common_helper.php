<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function create_years($start_year, $end_year, $id = 'year_select', $selected = NULL, $attributes = [])
{

	$default_attributes = [
		"class" => "select2 form-control"
	];

	$attributes = array_merge($default_attributes,$attributes);

	$attribute_string = "";
	foreach ($attributes as $key => $value) {
		$attribute_string .= " $key='$value' ";
	}

	/* CURRENT YEAR */
	$selected = is_null($selected) ? date('Y') : $selected;

	/* RANGE OF YEARS */
	$r = range($start_year,$end_year);

	/* CREATE SELECT OBJECT */
	$select = '<select name="'.$id.'" id="'.$id.'" '.$attribute_string.' placeholder="Select year">';
	foreach( $r as $year )
	{
		$select .= '<option value="'.$year.'"';
		$select .= ($year==$selected) ? ' selected="selected"' : '';
		$select .= '>'.$year.'</option>\n';
	}
	$select .= '</select>';

	return $select;
}

function create_months($id = 'month_select', $selected = NULL, $all = TRUE, $attributes = [])
{
	$default_attributes = [
		"class" => "selectize"
	];

	$attributes = array_merge($default_attributes,$attributes);

	$attribute_string = "";
	foreach ($attributes as $key => $value) {
		$attribute_string .= " $key='$value' ";
	}
	/* ARRAY OF MONTHS */
	$months = array(
			1=>'January',
			2=>'February',
			3=>'March',
			4=>'April',
			5=>'May',
			6=>'June',
			7=>'July',
			8=>'August',
			9=>'September',
			10=>'October',
			11=>'November',
			12=>'December');

	/*** current month ***/
	$selected = is_null($selected) ? date('m') : $selected;

	$select = '<select name="'.$id.'" id="'.$id.'" '.$attribute_string.'>';

	if($all)
		$select .= '<option value="0">All</option>\n';

	foreach($months as $key=>$mon)
	{
		$select .= "<option value=\"$key\"";
		$select .= ($key==$selected) ? ' selected="selected"' : '';
		$select .= ">$mon</option>\n";
	}
	$select .= '</select>';
	return $select;
}

function set_filename($filename,$path = './uploads/')
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

function do_upload($filename, $uploadPath = './uploads/'){
		$CI =& get_instance();
		$config['upload_path']          = $uploadPath;
		$config['allowed_types']        = '*';
		$config['max_size']             = 5000;
		// $config['max_width']            = 1000;
		// $config['max_height']           = 667;

		$CI->load->library('upload', $config);

		if ( ! $CI->upload->do_upload($filename))
		{
				$error = $CI->upload->display_errors();
		}
		else
		{
				$data = array('upload_data' => $CI->upload->data());
				$error = "";

		}
		
		return $error;
	}

function do_multiple_upload($params){
		$CI =& get_instance();
		// Count total files
		$countfiles = count($params['name']);
		$error = '';
		$params['name'] = array_values($params['name']);
		$params['type'] = array_values($params['type']);
		$params['tmp_name'] = array_values($params['tmp_name']);
		$params['error'] = array_values($params['error']);
		$params['size'] = array_values($params['size']);
		
		for($i=0;$i<$countfiles;$i++){
			if(!empty($params['name'][$i])){
				
				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = '*';
				$config['max_size']             = 5000;
				// $config['file_name'] = $params['name'][$i];
				$_FILES['file']['name'] = $params['name'][$i];
				$_FILES['file']['type'] = $params['type'][$i];
				$_FILES['file']['tmp_name'] = $params['tmp_name'][$i];
				$_FILES['file']['error'] = $params['error'][$i];
				$_FILES['file']['size'] = $params['size'][$i];

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

function number_to_words($number)
{
    $integer = $number;
	$num = number_format($number, 2, ".", ",");
	$fraction = substr(strrchr($num, "."), 1);

    $output = "";

    if ($integer[0] == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer[0] == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer[0] == "0")
    {
        $output .= "Zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11][0] == '0'
                            ? " and "
                            : ","
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
		$fraction = rtrim(chunk_split($fraction, 1, " "), " ");
        $fraction = explode(" ", $fraction);
		$fraction = convertTwoDigit($fraction[0], $fraction[1]);
		return $output;

    } else {

		return $output;

	}
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " Decillion";
        case 10:
            return " Nonillion";
        case 9:
            return " Octillion";
        case 8:
            return " Septillion";
        case 7:
            return " Sextillion";
        case 6:
            return " Quintrillion";
        case 5:
            return " Quadrillion";
        case 4:
            return " Trillion";
        case 3:
            return " Billion";
        case 2:
            return " Million";
        case 1:
            return " Thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " Hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "10";
            case "2":
                return "20";
            case "3":
                return "30";
            case "4":
                return "40";
            case "5":
                return "50";
            case "6":
                return "60";
            case "7":
                return "70";
            case "8":
                return "80";
            case "9":
                return "90";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "11";
            case "2":
                return "12";
            case "3":
                return "13";
            case "4":
                return "14";
            case "5":
                return "15";
            case "6":
                return "16";
            case "7":
                return "17";
            case "8":
                return "18";
            case "9":
                return "19";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "2$temp";
            case "3":
                return "3$temp";
            case "4":
                return "4$temp";
            case "5":
                return "5$temp";
            case "6":
                return "6$temp";
            case "7":
                return "7$temp";
            case "8":
                return "8$temp";
            case "9":
                return "9$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "0";
        case "1":
            return "1";
        case "2":
            return "2";
        case "3":
            return "3";
        case "4":
            return "4";
        case "5":
            return "5";
        case "6":
            return "6";
        case "7":
            return "7";
        case "8":
            return "8";
        case "9":
            return "9";
    }
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

function get_params($xss = TRUE)
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

/*
|----------------------------------------------------------------------
| Generation of Zoho Token
|----------------------------------------------------------------------
| Generation of Zoho token and auto redirect to dashboard
|
*/

function generateZohoToken(){
	$scope = array(
		'ZohoBooks.settings.READ',
		'ZohoBooks.settings.UPDATE',
		'ZohoBooks.contacts.READ',
		'ZohoBooks.contacts.CREATE',
		'ZohoBooks.invoices.CREATE',
		'ZohoBooks.invoices.READ',
		'ZohoBooks.invoices.UPDATE',
		'ZohoBooks.invoices.DELETE',
		'ZohoBooks.customerpayments.READ',
		'ZohoBooks.customerpayments.UPDATE',
		'ZohoBooks.customerpayments.CREATE',
		'ZohoInventory.inventoryadjustments.CREATE',
		'ZohoBooks.creditnotes.CREATE'
	);

	$clientId = '1000.F61OEST2ANLX3X11IHNBI3KOECBKNU';

	$scope = implode(',',$scope);
	// $redirectUrl = 'https://captivategrp.com/rebap/';
	$redirectUrl = 'https://wms.metromotorbikescorp.com/web-portal/dashboard';
	$url = 'https://accounts.zoho.com/oauth/v2/auth?scope='.$scope.'&client_id='.$clientId.'&response_type=code&redirect_uri='.$redirectUrl.'&access_type=offline&prompt=consent';
	redirect($url);
}

/*
|----------------------------------------------------------------------
| Generation of Zoho Access Token
|----------------------------------------------------------------------
| To be used in the API Calls, must be save to session
|
*/

function generateZohoAccessToken($code){
	$clientId = '1000.F61OEST2ANLX3X11IHNBI3KOECBKNU';
	$clientSecret = 'bc32d99edf46b483beee7fec9256966a05c4769a8c';
	// $redirectUrl = 'https://captivategrp.com/rebap/';
	$redirectUrl = 'https://wms.metromotorbikescorp.com/web-portal/dashboard';
	$url = 'https://accounts.zoho.com/oauth/v2/token?code='.$code.'&client_id='.$clientId.'&client_secret='.$clientSecret.'&redirect_uri='.$redirectUrl.'&grant_type=authorization_code';

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_HTTPHEADER => array(
		'Cookie: b266a5bf57=dcb92d0f99dd7421201f8dc746d54606; iamcsr=2f94cd14-5179-4b31-bf5e-e1e4f912011b; _zcsr_tmp=2f94cd14-5179-4b31-bf5e-e1e4f912011b; e188bc05fe=8db261d30d9c85a68e92e4f91ec8079a; stk=52258d6a5e2fdf575ae7299a96d3b986'
	),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return json_decode($response);
}

/*
|----------------------------------------------------------------------
| Generation of Zoho Refresh Token
|----------------------------------------------------------------------
| To be used in the API Calls, Access Token is pre-requisite.
|
*/

function generateRefreshToken($authCode){
	$CI =& get_instance();
	// $accessToken = '1000.f2c6c5e0143ac957bcd6398c5bdb8881.b0f95475850f8b0ff62d0f88812fe00b';
	$clientId = '1000.F61OEST2ANLX3X11IHNBI3KOECBKNU';
	$clientSecret = 'bc32d99edf46b483beee7fec9256966a05c4769a8c';

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token?refresh_token='.$authCode.'&client_id='.$clientId.'&client_secret='.$clientSecret.'&grant_type=refresh_token',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_HTTPHEADER => array(
		'Cookie: b266a5bf57=dcb92d0f99dd7421201f8dc746d54606; iamcsr=2f94cd14-5179-4b31-bf5e-e1e4f912011b; _zcsr_tmp=2f94cd14-5179-4b31-bf5e-e1e4f912011b; e188bc05fe=8db261d30d9c85a68e92e4f91ec8079a; stk=52258d6a5e2fdf575ae7299a96d3b986'
	),
	));
	// set_time_limit(0);
	$response = curl_exec($curl);

	curl_close($curl);
	$response = json_decode($response);
	// set_time_limit(30);
	if(isset($response->error)){
		
		$CI->session->set_flashdata('message','Error in Authenticating Zoho Token! Please Log in Again');
		redirect(base_url());
	}
	return $response->access_token;
}

/*
|----------------------------------------------------------------------
| Generation of Zoho Items
|----------------------------------------------------------------------
| List of Zoho Items, Refresh Token is pre-requisite.
|
*/

function generateZohoItems($authCode, $branchCode = ""){

	$year = date('Y');
	$month = date('n');

	$q1 = array(1,2,3);
	$q2 = array(4,5,6);
	$q3 = array(7,8,9);
	$q4 = array(10,11,12);

	if(in_array($month,$q1)){
		$quarter = "Q1";
	}elseif(in_array($month,$q2)){
		$quarter = "Q2";
	}elseif(in_array($month,$q3)){
		$quarter = "Q3";
	}else{
		$quarter = "Q4";
	}

	if($branchCode != ""){
		$branchAppend = "&search_text=".$branchCode."-".$year."-".$quarter;
	}
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://books.zoho.com/api/v3/items?organization_id=731717588'.$branchAppend,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken '.$authCode.'',
		'Cookie: BuildCookie_731717588=1; stk=897f2e5cfa6e52c301b58dd2bd20b65e; ba05f91d88=aa16804f02271c4b626d7e125e9b56fc; zbcscook=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; _zcsr_tmp=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; JSESSIONID=C3C2B4A4BCF4B41B8AA481DE70C3FC1D'
	),
	));

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
	
}

/*
|----------------------------------------------------------------------
| Generation of Zoho Customer
|----------------------------------------------------------------------
| List of Zoho Customer, Refresh Token is requisite.
|
*/

function generateZohoCustomers($authCode){

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://books.zoho.com/api/v3/contacts?organization_id=',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken '.$authCode.'',
		'Cookie: BuildCookie_731717588=1; stk=897f2e5cfa6e52c301b58dd2bd20b65e; ba05f91d88=aa16804f02271c4b626d7e125e9b56fc; zbcscook=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; _zcsr_tmp=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; JSESSIONID=C3C2B4A4BCF4B41B8AA481DE70C3FC1D'
	),
	));

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
	
}

/*
|----------------------------------------------------------------------
| Generation of Zoho Contact Person
|----------------------------------------------------------------------
| List of Zoho Contact Person, Refresh Token is pre-requisite.
|
*/

function generateZohoContactPersons($authCode,$customerId){

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://books.zoho.com/api/v3/contacts/'.$customerId.'/contactpersons?organization_id=',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken '.$authCode.'',
		'Cookie: BuildCookie_731717588=1; stk=897f2e5cfa6e52c301b58dd2bd20b65e; ba05f91d88=aa16804f02271c4b626d7e125e9b56fc; zbcscook=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; _zcsr_tmp=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; JSESSIONID=C3C2B4A4BCF4B41B8AA481DE70C3FC1D'
	),
	));

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
	
}

/*
|----------------------------------------------------------------------
| Generation of Specific Invoice
|----------------------------------------------------------------------
| Details of Specific Invoice, Invoice Id and Refresh Token is pre-requisite.
|
*/

function generateSpecificZohoInvoice($authCode, $invoiceId){

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://books.zoho.com/api/v3/invoices/'.$invoiceId.'?organization_id=',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken '.$authCode.'',
		'Cookie: BuildCookie_731717588=1; stk=897f2e5cfa6e52c301b58dd2bd20b65e; ba05f91d88=aa16804f02271c4b626d7e125e9b56fc; zbcscook=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; _zcsr_tmp=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; JSESSIONID=C3C2B4A4BCF4B41B8AA481DE70C3FC1D'
	),
	));

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
	
}

/*
|----------------------------------------------------------------------
| Generation of Specific Item
|----------------------------------------------------------------------
| Details of Specific Item, Item Id and Refresh Token is pre-requisite.
|
*/

function generateSpecificZohoItem($authCode, $itemId){

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://books.zoho.com/api/v3/items/'.$itemId.'?organization_id=',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken '.$authCode.'',
		'Cookie: BuildCookie_731717588=1; stk=897f2e5cfa6e52c301b58dd2bd20b65e; ba05f91d88=aa16804f02271c4b626d7e125e9b56fc; zbcscook=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; _zcsr_tmp=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; JSESSIONID=C3C2B4A4BCF4B41B8AA481DE70C3FC1D'
	),
	));

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
	
}

/*
|----------------------------------------------------------------------
| Integrate to Zoho
|----------------------------------------------------------------------
| Function to update data into zoho
|
*/

function integrateIntoZoho($url, $dataUrl,$authCode){
	// $authCode = '1000.8788f746c38255aae0d123c19e53db4a.74e10586903fb3da61886e0dea00c000';
	$ch = curl_init($url);
			
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataUrl));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded","Authorization: Zoho-oauthtoken ".$authCode."") );
	
	$response = curl_exec($ch);
	curl_close($ch);
	
	// --------------------------------------
	return json_decode($response);
}

/*
|----------------------------------------------------------------------
| Integrate to Zoho Item
|----------------------------------------------------------------------
| Specific Function to update quantity of Item into Zoho.
| Zoho Inventory is used
|
*/

function integrateIntoZohoItem($url, $dataUrl,$authCode){
	// $authCode = '1000.8788f746c38255aae0d123c19e53db4a.74e10586903fb3da61886e0dea00c000';
	$ch = curl_init($url);
			
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataUrl));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded","Authorization: Zoho-oauthtoken ".$authCode."") );
	
	$response = curl_exec($ch);
	curl_close($ch);
	
	// --------------------------------------
	return json_decode($response);
}

/*
|----------------------------------------------------------------------
| List of Zoho Invoices
|----------------------------------------------------------------------
| List of Zoho Invoices, Refresh Token is pre-requisite.
|
*/

function generateZohoInvoices($authCode){

	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://books.zoho.com/api/v3/invoices?organization_id=',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken '.$authCode.'',
		'Cookie: BuildCookie_731717588=1; stk=897f2e5cfa6e52c301b58dd2bd20b65e; ba05f91d88=aa16804f02271c4b626d7e125e9b56fc; zbcscook=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; _zcsr_tmp=ea1d27f4-7b31-4f0b-844a-e135d5d07a77; JSESSIONID=C3C2B4A4BCF4B41B8AA481DE70C3FC1D'
	),
	));

	$response = curl_exec($curl);
	curl_close($curl);

	return $response;
	
}




function getParams($xss = TRUE)
{
  $CI =& get_instance();
  $get = $CI->input->get(NULL, $xss) ? $CI->input->get(NULL, $xss) : array();
  $post = $CI->input->post(NULL, $xss) ? $CI->input->post(NULL, $xss) : array();
  $params = array_merge(array_merge($get, $post), $_FILES);

  return $params;
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
