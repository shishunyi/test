<?php

namespace app\admin\controller;
use think\Controller;

class Common extends Controller{

    public function __construct()
    {
        if(session('adminuserid') == null || session('adminuserid') == '')
        {
            $this->redirect('/rootlogin');
        }
    }





}