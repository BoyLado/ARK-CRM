<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = "Arkonor LLC | Login";
        $data['userAuthCode'] = "";
        return $this->slice->view('login', $data);
    }
}
