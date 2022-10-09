<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->users = model('Portal/Users');
    }

    public function loadUsers()
    {
        $whereParams = [
            'id !=' => $this->session->get('arkonorllc_user_id'),
            'user_status' => '1'
        ];
        $arrResult = $this->users->loadUsers($whereParams);
        return $this->response->setJSON($arrResult);
    }

    public function loadPendingInvites()
    {
        $whereParams = ['user_status' => '0'];
        $arrResult = $this->users->loadUsers($whereParams);
        return $this->response->setJSON($arrResult);
    }

    public function inviteNewUser()
    {
        $this->validation->setRules([
            'txt_userEmail' => [
                'label'  => 'Email Address',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'User Email is required',
                    'valid_email' => 'User Email must be valid'
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();

            $arrData = [
                'user_email'     => $fields['txt_userEmail'],
                'user_auth_code' => encrypt_code(generate_code()),
                'user_status'    => '0',
                'created_date'   => date('Y-m-d H:i:s')
            ];

            $result = $this->users->loadUser(['user_email'=>$fields['txt_userEmail']]);
            if($result == null)
            {
                $result = $this->users->inviteNewUser($arrData);
                if($result > 0)
                {
                    $emailSender    = 'ajhay.work@gmail.com';
                    $emailReceiver  = $fields['txt_userEmail'];

                    $arrResult = $this->users->loadUser(['user_email'=>$emailReceiver]);

                    $data['subjectTitle'] = 'Invite New User';
                    $data['userId'] = $arrResult['user_id'];
                    $data['userAuthCode'] = decrypt_code($arrResult['user_auth_code']);

                    $emailResult = sendSliceMail('invite_user',$emailSender,$emailReceiver,$data);
                    $msgResult[] = ($emailResult == 1)? "Success" : $emailResult;
                }
                else
                {
                    $msgResult[] = "Error! <br>Database error!";
                }
            }
            else
            {
                $msgResult[] = "Error! <br>Email already exist!";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }
        return $this->response->setJSON($msgResult);
    }


    ////////////////////////////////////////////////////////////////////
    ///// USER PROFILE SCRIPTS
    ////////////////////////////////////////////////////////////////////
    public function loadProfile()
    {
        $userId = $this->session->get('arkonorllc_user_id');

        $arrResult = $this->users->loadProfile($userId);
        return $this->response->setJSON($arrResult);
    }

    public function changeProfilePicture()
    {
        $this->validation->setRules([
            'profilePicture' => [
                'label'  => 'Profile Picture',
                'rules'  => 'uploaded[profilePicture]|max_size[profilePicture,3024]|ext_in[profilePicture,jpeg,jpg,png,gif]',
                'errors' => [
                    'max_size'    => 'Max size is 3024 KB',
                    'ext_in'      => 'Invalid file extention'
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $userId = $this->session->get('arkonorllc_user_id');
            $imageFile = $this->request->getFile('profilePicture');

            $newFileName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'public/assets/uploads/img', $newFileName);

            if($imageFile->hasMoved())
            {
                $whereParams = ['id' => $userId];
                $arrResult = $this->users->loadUser($whereParams);

                unlink(ROOTPATH . 'public/assets/uploads/img/' . $arrResult['picture']);

                $arrData = [
                    'picture'      => $newFileName,
                    'updated_date' => date('Y-m-d H:i:s')
                ];

                $result = $this->users->changeProfilePicture($arrData, $userId);
                $msgResult[] = ($result > 0)? "Success" : "Database error";
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }
        return $this->response->setJSON($msgResult);
    }

    public function loadDetails()
    {
        $userId = $this->session->get('arkonorllc_user_id');

        $arrResult = $this->users->loadDetails($userId);
        return $this->response->setJSON($arrResult);
    }

    public function editDetails()
    {
        $this->validation->setRules([
            'slc_salutation' => [
                'label'  => 'Salutation',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Salutation is required'
                ],
            ],
            'txt_firstName' => [
                'label'  => 'First Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'First Name is required'
                ],
            ],
            'txt_lastName' => [
                'label'  => 'Last Name',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Last Name is required'
                ],
            ],
            'txt_position' => [
                'label'  => 'Position',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Position is required'
                ],
            ],
            'txt_email' => [
                'label'  => 'Email Address',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'User Email is required',
                    'valid_email' => 'User Email must be valid'
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            $userId = $this->session->get('arkonorllc_user_id');

            $arrData = [
                'salutation'    => $fields['slc_salutation'],
                'first_name'    => $fields['txt_firstName'],
                'last_name'     => $fields['txt_lastName'],
                'position'      => $fields['txt_position'],
                'user_email'    => $fields['txt_email'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            $result = $this->users->editDetails($arrData, $userId);
            $msgResult[] = ($result > 0)? "Success" : "Database error";
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }
        
        return $this->response->setJSON($msgResult);
    }

    public function editPassword()
    {
        $this->validation->setRules([
            'txt_oldPassword' => [
                'label'  => 'Old Password',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'Old Password is required'
                ],
            ],
            'txt_newPassword' => [
                'label'  => 'New Password',
                'rules'  => 'required',
                'errors' => [
                    'required'    => 'New Password is required'
                ],
            ],
        ]);

        if($this->validation->withRequest($this->request)->run())
        {
            $fields = $this->request->getPost();
            $userId = $this->session->get('arkonorllc_user_id');

            $arrWhere = [
                'id' => $userId,
                'user_password' => encrypt_code($fields['txt_oldPassword'])
            ];

            $checkOldPassword = $this->users->validateLogIn($arrWhere);

            if(!empty($checkOldPassword))
            {
                $arrData = [
                    'user_password' => encrypt_code($fields['txt_newPassword'])
                ];

                $result = $this->users->editPassword($arrData, $userId);
                $msgResult[] = ($result > 0)? "Success" : "Database error";
            }
            else
            {
                $msgResult[] = 'Old Password is Incorrect!';
            }
        }
        else
        {
            $msgResult[] = $this->validation->getErrors();
        }

        return $this->response->setJSON($msgResult);
    }

}
