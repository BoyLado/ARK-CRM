<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class NavigationController extends BaseController
{
    public function index()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Login";
        $data['userAuthCode'] = "";
        return $this->slice->view('login', $data);
    }

    public function dashboard()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Dashboard";
        return $this->slice->view('dashboard', $data);
    }

    public function login()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Login";
        $data['userAuthCode'] = "";
        return $this->slice->view('login', $data);
    }

    public function loginWithAuth($userAuthCode)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Login";
        $data['userAuthCode'] = $userAuthCode;
        return $this->slice->view('login', $data);
    }

    public function forgotPassword()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Forgot Password";
        return $this->slice->view('forgot_password', $data);
    }

    public function changePassword($userId, $userAuthCode, $passwordAuthCode)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Change Password";
        $data['userId'] = $userId;
        $data['userAuthCode'] = $userAuthCode;
        $data['passwordAuthCode'] = $passwordAuthCode;
        return $this->slice->view('change_password', $data);
    }

    public function signUp($userId, $userAuthCode)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                return redirect()->to(base_url() . '/contacts');
            }
        }
        $data['pageTitle'] = "Arkonor LLC | Sign Up";
        $data['userId'] = $userId;
        $data['userAuthCode'] = $userAuthCode;
        return $this->slice->view('sign_up', $data);
    }

    
}
