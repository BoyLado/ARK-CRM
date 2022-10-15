<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UnsubscribeController extends BaseController
{
    public function __construct()
    {
        $this->contacts = model('Portal/Contacts');
        $this->email_templates = model('Portal/EmailTemplates');
    }

    public function contactUnsubscribe($contactId, $authCode, $contactEmail)
    {
        $arrData = $this->contacts->verifyContact($contactId, encrypt_code($authCode));

        if($arrData != null && $contactEmail != false)
        {
            $emailSender    = 'ajhay.dev@gmail.com';
            $emailReceiver  = $contactEmail;

            $data['subjectTitle']                = 'Unsubscribe Confirmation';
            $unsubscribeConfirmationLink         = "contact-confirmation/".$contactId."/".$authCode."/".$contactEmail;
            $data['unsubscribeConfirmationLink'] = $unsubscribeConfirmationLink;

            $emailResult = sendSliceMail('unsubscribe_confirmation',$emailSender,$emailReceiver,$data);
            $msgResult[] = ($emailResult == 1)? "Success" : $emailResult;
        }
        else
        {
            $msgResult[] = "Error 401 Unauthorized!";
        }

        return $this->response->setJSON($msgResult);
    }

    public function contactConfirmation($contactId, $authCode, $contactEmail)
    {
        $arrData = $this->contacts->verifyContact($contactId, encrypt_code($authCode));

        if($arrData != null && $contactEmail != false)
        {
            $emailSender    = 'ajhay.dev@gmail.com';
            $emailReceiver  = 'ajhay.work@gmail.com';

            $data['subjectTitle']    = 'Unsubscribe Notification';
            $data['contactName']     = $arrData['full_name'];
            $data['contactPosition'] = $arrData['position'];
            $data['contactEmail']    = $contactEmail;

            $emailResult = sendSliceMail('unsubscribe_notification',$emailSender,$emailReceiver,$data);

            if($emailResult == 1)
            {
                $arrData = ['email_opt_out'=>1];
                $result = $this->contacts->emailOptOut($contactId, $arrData);
            }
            else
            {
                $result = 0;
            }

            $msgResult[] = ($result > 0)? "Success" : "Database Error";
        }
        else
        {
            $msgResult[] = "Error 401 Unauthorized!";
        }

        return $this->response->setJSON($msgResult);
    }
}
