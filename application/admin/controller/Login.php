<?php
namespace app\Admin\controller;
use think\Db;
class Login{

    public function login()
    {
        if(request()->isAjax()){
            try{
                $res = model('Admin')->checkLogin(request()->param('user'),request()->param('pwd'));
                if($res){
                    return json(['code'=>0]);
                }
                return json(['code'=>1,'msg'=>'登陆失败！']);
            }catch (\Exception $e){
                return json(['code'=>1,'msg'=>$e->getMessage()]);
            }
        }
        return view();
    }
}