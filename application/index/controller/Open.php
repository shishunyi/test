<?php
namespace app\index\controller;
use think\Controller;
class Open extends Controller
{

    public function index()
    {


        return view('./static/index/index.html');
    }
    public function test()
    {

        return view();
    }
    public function login()
    {
        try{
            $result = model('Member')->verifyPassWord(request()->param('username'),request()->param('password'));
            if($result){
                return json(['code'=>0,'msg'=>'登录成功！','user'=>$result]);
            }
            return json(['code'=>1,'msg'=>'登录失败哦']);
        }catch (\Exception $e){
            return json(['code'=>1,'msg'=>$e->getMessage()]);
        }

    }

    public function register()
    {
        try{
            $result = model('Member')->registerMember(
                request()->param('username'),
                request()->param('password'),
                request()->param('gameid'),
                request()->param('nickname'),
                request()->param('translate'),
                request()->param('headimgurl')
            );
            if($result){
                return json(['code'=>0,'msg'=>'登录成功！','user'=>$result]);
            }
            return json(['code'=>1,'msg'=>'登录失败哦']);
        }catch (\Exception $e){
            return json(['code'=>1,'msg'=>$e->getMessage()]);
        }
    }


    public function logout()
    {
        session('userid',null);
        return true;
    }


    public function upload()
    {
// 获取表单上传文件 例如上传了001.jpg
        try{
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){

                $info = $file->validate(['ext'=>'jpg,png,bmp,gif,tmp,jpeg'])->move('./uploads/headimg');
                if($info){
                    // 成功上传后 获取上传信息
                    return json(['errcode'=>0,'message'=>'/uploads/headimg/'.$info->getSaveName()]);
                }else{
                    // 上传失败获取错误信息
                    return json(['errcode'=>1,'message'=>"上传失败".$file->getError()]);
                }
            }
        }catch (\Exception $e){
            return json(['errcode'=>1,'message'=>"上传失败".$e->getMessage()]);

        }
    }

}
