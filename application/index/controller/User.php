<?php
namespace app\index\controller;

class User extends Common
{
    public function memberInfo()
    {
        if(request()->param('id')){
            $validate = new \app\index\validate\User;
            $param = request()->param();
            if($validate->check($param)){
                if(model('Member')->where('id','<>',request()->param('id'))->where('username','=',$param['username'])->find()){
                    return json(['code'=>1,'msg'=>'账号信息已被占用！']);
                }
                if(model('Member')->where('id','<>',request()->param('id'))->where('gameid','=',$param['gameid'])->find()){
                    return json(['code'=>1,'msg'=>'gameid已被占用！']);
                }
                $res = model('Member')->save([
                    'username'=>$param['username'],
                    'password'=>md5($param['password']),
                    'gameid'=>$param['gameid'],
                    'nickname'=>$param['nickname'],
                    'translate'=>$param['translate'],
                    'remake'=>$param['password'],
                    'headimgurl'=>$param['headimgurl']

                ],['id'=>$param['id']]);
                if($res){
                    return json(['code'=>0,'msg'=>'修改成功！']);
                }
                return json(['code'=>1,'msg'=>'修改失败！']);
            }else{
                return json(['code'=>1,'msg'=>$validate->getError()]);
            }
        }
        $cid = $this->userid;
        if(request()->param('uid')){
            $cid= request()->param('uid');
        }
        $user = model('member')->field('id,username,gameid,nickname,remake,group_root,group_servertime,translate,headimgurl,session_key')->find($cid);


        if($user['group_root'] == '1' && strtotime($user['group_servertime']) > time()){

            $user['shengyushijian'] = intval((strtotime($user['group_servertime']) - strtotime(date('Y-m-d',time()))) / (24 * 60 * 60));
        }else{

            $user['shengyushijian'] = 0;
        }
        return json(['code'=>0,'msg'=>$user]);
    }

    public function loginout()
    {
        session(null);
        return true;
    }
}