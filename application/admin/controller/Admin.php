<?php
namespace app\admin\controller;

class Admin extends Common {

    public function index()
    {
        $adminuser = model('admin')->where('id','=',session('adminuserid'))->find();
        return view('',['adminuser'=>$adminuser]);
    }
}