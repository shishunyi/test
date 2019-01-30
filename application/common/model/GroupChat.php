<?php

namespace app\common\model;
use think\Exception;
use think\model\concern\SoftDelete;
class GroupChat extends \think\Model{
    use SoftDelete;
    protected $deleteTime = 'deletetime';
    public static function instance()
    {
        return new self();
    }
    public function member()
    {
        return $this->belongsTo('member','uid','id');
    }

    public function chatmember()
    {
        return $this->hasMany('GroupMember','gid','id');
    }


    public function getCreatetimeAttr($val)
    {
        return date('Y-m-d H:i:s',$val);
    }

    public function createGroup($groupname,$groupheadimg,$id=0)
    {
        $user = Member::instance()->find(session('userid'));



        if(!$user['group_root'] || strtotime($user['group_servertime']) < time()){
            throw new \Exception('你无权限创建！');
        }

        $gcount = $this->where('uid','=',session('userid'))->count();
        $user = Member::instance()->get(session('userid'));
        if($user['group_count'] <= $gcount){
            throw new \Exception('你的领地创建已经达到极限，如需创建更多请联系客服');
        }
        $validate = new \app\index\validate\Group;
        if($validate->check(['groupname'=>$groupname,'groupheadimg'=>$groupheadimg])){
            if(!file_exists('.'.$groupheadimg)){
                throw new \Exception('领地头像图片文件不存在！');
            }


                if($this->where(['groupname'=>$groupname])->where('id','<>',$id)->find()){

                    throw new \Exception('群组名称已存在！');

                }

            $data = [
                    'uid'=>session('userid'),
                    'groupname'=>$groupname,
                    'groupheadimg'=>$groupheadimg,

                    'createtime'=>time()
                ];
            if(!$id){

                $result = $this->insertGetId($data);

                //群主用户创建

                GroupMember::instance()->createGroupMember(session('userid'),$result,1,session('userid'));
            }else{
                unset($data['createtime']);
                $data['updatetime']=time();
                $result = $this->save($data,['id'=>$id]);
            }
            if($result){
                return true;
            }
            throw new \Exception('创建群组失败！');

        }else{
            throw new \Exception($validate->getError());
        }
    }




}