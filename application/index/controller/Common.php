<?php
namespace app\index\controller;

class Common
{
    public function __construct()
    {

        if(!session('userid')){
            throw new \Exception('请先登录！');
        }
        $this->userid = session('userid');

    }




}
