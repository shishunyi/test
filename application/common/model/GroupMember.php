<?php

namespace app\common\model;
use think\Exception;

class GroupMember extends \think\Model{


    public static function instance()
    {
        return new self();
    }

    public function member()        //关联群主
    {
        return $this->belongsTo('member','rootid','id');
    }

    public function member2()       //关联用户
    {
        return $this->belongsTo('member','uid','id');
    }

    public function group()
    {
        return $this->belongsTo('GroupChat','gid','id');
    }
    public function createGroupMember($uid,$gid,$isroot,$rootid)
    {
        return $this->save(['uid'=>$uid,'gid'=>$gid,'isroot'=>$isroot,'state'=>'1','rootid'=>$rootid,'createtime'=>time()]);
    }

    public function joinGroup($gid,$uid)
    {
        $chat = GroupChat::instance()->where('id','=',$gid)->find();
        if($chat){
            if(!$this->where('gid','=',$gid)->where('uid','=',$uid)->find()){
                $res = $this->save([
                    'gid'=>$gid,
                    'uid'=>$uid,
                    'isroot'=>'0',
                    'rootid'=>$chat['uid'],
                    'createtime'=>time()
                ]);
                if($res){
                    return true;
                }
                throw new \Exception('添加失败！');
            }
            throw new \Exception('已请求过此群组，请勿反复添加！');
        }
        throw new \Exception('未找到群组！');
    }


    public function shenHeGroupMember($gid,$uid,$state)
    {
        if($state == '1'){
            $state = '1';
        }else{
            $state = '2';
        }
        if($this->save(['state'=>$state],['gid'=>$gid,'uid'=>$uid])){
            return true;
        }
        throw new \Exception('失败！');
    }
}