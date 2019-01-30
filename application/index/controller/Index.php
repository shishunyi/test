<?php
namespace app\index\controller;

class Index extends Common
{
    public function grouplist()
    {
        $page = request()->param('page/d') ?? 1;
        $pagesize = request()->param('pagesize/d') ?? 10;
        $where[] = ['uid','=',$this->userid];
        $where[] = ['state','=','1'];
        if(request()->param('mygroup')){
            $where[] = ['rootid','=',$this->userid];
        }
        $list = model('GroupMember')->alias('a')
                ->withJoin(['member'=>function($query){
                    $query->where('group_root','=','1')->where('group_servertime','>',time())->field('member.id,member.nickname');
                }],'left')
                ->with('group')
                ->where($where)
                ->page($page,$pagesize)
                ->select();
        $counts =model('GroupMember')->alias('a')
                ->withJoin(['member'=>function($query){
                    $query->where('group_root','=','1')->where('group_servertime','>',time())->field('member.id,member.nickname');
                }],'left')
                ->where($where)
                ->count();
        return json(['lists'=>$list,'count'=>$counts]);

    }



    //创建群组

    public function createGroup()
    {
        $id = request()->param('id')??0;
        try{
            $res = model('GroupChat')->createGroup(request()->param('groupname'),request()->param('groupheadimg'),$id);
            if($res){
                return json(['code'=>0,'msg'=>'创建成功！']);
            }
            return json(['code'=>1,'msg'=>'创建失败！']);
        }catch (\Exception $e){
            return json(['code'=>1,'msg'=>$e->getMessage()]);
        }
    }

    //群组详情
    public function groupInfo()
    {
        if(request()->param('gid')){
            $res = model('GroupChat')->with(['member'=>function($query){$query->field('id,nickname');}])->get(request()->param('gid'));
            if($res){
                return json(['code'=>0,'msg'=>$res]);
            }else{
                return json(['code'=>1,'msg'=>'未找到此群组！']);
            }
        }
    }

    /*
     * 加入群组
     * */
    public function joinGroup()
    {

        try{
            $res = model('GroupMember')->joinGroup(request()->param('gid'),session('userid'));
            if($res){
                return json(['code'=>0,'msg'=>'申请成功！,请等待领主审核！']);
            }
            return json(['code'=>1,'msg'=>'创建失败！']);
        }catch (\Exception $e){
            return json(['code'=>1,'msg'=>$e->getMessage()]);
        }
    }


    /*
     * 聊天记录
     * */
    public function chatRecord()
    {
        $gid = request()->param('gid');
        $page = request()->param('page') ?? 1;
        $pagesize = 10;
        $list = [];
        $where[] = ['gid','=',$gid];

        if($gid){
            $list = model('GroupChatRecord')
                ->with(['member'=>function($query){
                    $query->field('id,gameid,nickname,headimgurl');
                }])
                ->where('gid','=',$gid)
                ->order('createtime desc')
                ->where($where)
                ->page($page,$pagesize)
                ->select()->toArray();

        }
        return json(['code'=>0,'msg'=>array_reverse($list)]);
    }
    /*
     * 成员列表
     * */

    public function groupUser()
    {

        $gid = request()->param('gid');
        $page = request()->param('page') ?? 1;
        $pagesize = 10;
        $where[] = ['gid','=',$gid];

        if(request()->param('shenhe')){
            $where[] = ['state','=','0'];
        }else{
            $where[] = ['state','=','1'];
        }
        $where2 = [];
        if(request()->param('nickname')){
            $where2[] = ['member2.nickname','like','%'.request()->param('nickname').'%'];
        }
        if(request()->param('id/d')){
            $where2[] = ['member2.id','=',request()->param('id')];
        }
        $list = [];
        if($gid){
            $list = model('GroupMember')
                ->withJoin(['member2'=>function($query) use($where2){
                    $query->where($where2)->field('member2.id,member2.nickname,member2.gameid,member2.headimgurl');
                }],'left')
                ->where($where)
                ->order('createtime desc')
                ->page($page,$pagesize)
                ->select();

        }
        return json(['code'=>0,'msg'=>$list]);
    }

    /*
     * 群成员审核
     * */

    public function groupShenhe()
    {
        if(request()->param('gid/d') && request()->param('uid/d')){
            try{
                $res = model('GroupMember')->shenHeGroupMember(request()->param('gid'),request()->param('uid/d'),request()->param('state'));
                if($res){
                    return json(['code'=>0,'msg'=>'操作成功！']);
                }
                return json(['code'=>1,'msg'=>'创建失败！']);
            }catch (\Exception $e){
                return json(['code'=>1,'msg'=>$e->getMessage()]);
            }
        }
    }

    /*
     * 群成员踢出
     * */
    public function deleteGroupUser()
    {
        if(request()->param('uid/d')){
            $res = model('GroupMember')->where('rootid','=',$this->userid)->where('gid','=',request()->param('gid'))->where('uid','=',request()->param('uid'))->where('uid','<>',$this->userid)->delete();
            if($res){
               return json(['code'=>0,'msg'=>'已踢出成员！']);
            }
            return json(['code'=>1,'msg'=>'踢出失败！']);
        }
    }


}
