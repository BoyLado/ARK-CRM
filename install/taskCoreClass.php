<?php
date_default_timezone_set('Asia/Manila');
class Core {
	function checkEmpty($data)
	{
	    if(!empty($data['hostname']) && !empty($data['username']) && !empty($data['database']) && !empty($data['template']) && !empty($data['slc_salutation']) && !empty($data['txt_firstName']) && !empty($data['txt_lastName']) && !empty($data['txt_email']) && !empty($data['txt_password']) && !empty($data['txt_confirmPassword'])){
	        return true;
	    }else{
	        return false;
	    }
	}

	function confirmPassword($data)
	{
		if($data['txt_password'] == $data['txt_confirmPassword'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function show_message($type,$message) {
		return $message;
	}
	
	function getAllData($data) {
		return $data;
	}

	function write_config($data) {

        if($data['template'] == 2){
		    $template_path 	= 'includes/templatevtwo.php';
        }else if($data['template'] == 3){
            $template_path 	= 'includes/templatevthree.php';
        }
		$output_path 	= '../application/config/database.php';

		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);

		$handle = fopen($output_path,'w+');
		@chmod($output_path,0777);
		
		if(is_writable(dirname($output_path))) {

			if(fwrite($handle,$new)) {
				
				$outputPath = 'assets/sqlcommand.sql';

				$sqlCommand_file = file_get_contents($outputPath);

				$output = str_replace("%SALUTATION%",$data['slc_salutation'],$sqlCommand_file);
				$output = str_replace("%FIRST_NAME%",$data['txt_firstName'],$output);
				$output = str_replace("%LAST_NAME%",$data['txt_lastName'],$output);
				$output = str_replace("%USER_EMAIL%",$data['txt_email'],$output);
				$output = str_replace("%USER_PASSWORD%",$this->encryptCode($data['txt_password']),$output);
				$output = str_replace("%AUTH_CODE%",$this->encryptCode('asd123'),$output);
				$output = str_replace("%CREATED_DATE%",date('Y-m-d H:i:s'),$output);

				$hand = fopen($outputPath,'w+');
				@chmod($outputPath,0777);

				if(is_writable(dirname($outputPath))) {
					if(fwrite($hand,$output)) {
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}

			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// function generateCode()
	// {
	// 	$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 10);
	// 	return $code;
	// }
	
	function encryptCode($decrypted_code)
	{
		$sSalt = 'abcdefghijklmnopqrstvwxyz0123456789';
		$sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
		$method = 'aes-256-cbc';

		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		$result = base64_encode(openssl_encrypt($decrypted_code, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
		  
		return $result;
	}

	function checkFile(){
	    $output_path = '../application/config/database.php';
	    
	    if (file_exists($output_path)) {
           return true;
        } 
        else{
            return false;
        }
	}
}