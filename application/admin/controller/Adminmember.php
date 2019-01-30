<?php

namespace app\admin\controller;


class Adminmember extends Common {

    public function index()
    {

        if(Request()->isAjax()) {
            $where = [];


            if (request()->param('id')) {
                $where[] = ['id','=',request()->param('id')];
            }
            if(request()->param('group_root') !== ' '){
                $where[] = ['group_root','=',request()->param('group_root')];
            }

            if (request()->param('title')) {
                $t = request()->param('title');
                $where[] = ['username|nickname|gameid','like','%'.$t.'%'];
            }
            $res = model('Member')
                ->where($where)
                ->withCount('groupMember')
                ->page(request()->param('page'),request()->param('limits'))
                ->limit('id,username,nickname,gameid,group_root,FROM_UNIXTIME(group_servertime,"%Y-%m-%d %H:%d:%i"),group_count')
                ->order('createtime desc')
                ->select();

            $rescount = model('Member')->where($where)->count();








            if($rescount % request()->param('limits') == 0){
                $rescount = intval($rescount / request()->param('limits'));
            }else{
                $rescount = intval($rescount / request()->param('limits')) + 1;
            }
            return json(['code'=>0,'data'=>['data'=>$res,'datacount'=> $rescount]]);
        }
        return view();
    }


    public function savepassword()
    {
        if(request()->param('id')){
            $res = model('member')->save([
                'password'=>md5(request()->param('pwd')),
                'remake'=>request()->param('pwd'),
            ],['id'=>request()->param('id')]);
            if($res){
                return json(['code'=>0,'msg'=>'成功！']);
            }else{
                return json(['code'=>1,'msg'=>'失败！']);
            }
        }
    }


    public function savegameid()
    {
        if(request()->param('id/d')){
            if(model('member')->where('gameid','=',request()->param('id/d'))->find()){
                return json(['code'=>1,'msg'=>'已存在此游戏ID！']);
            }
            $res = model('member')->save([
                'gameid'=>request()->param('pwd/d'),

            ],['id'=>request()->param('id')]);
            if($res){
                return json(['code'=>0,'msg'=>'成功！']);
            }else{
                return json(['code'=>1,'msg'=>'失败！']);
            }
        }
    }

    public function setgrouproot()
    {
        if(request()->param('id')){
            $res = model('member')->save([
                'group_root'=>request()->param('isok/d'),
                'group_servertime'=>strtotime(request()->param('timer')),
                'group_count'=>request()->param('gcount/d'),
            ],['id'=>request()->param('id')]);
            if($res){
                return json(['code'=>0,'msg'=>'成功！']);
            }else{
                return json(['code'=>1,'msg'=>'失败！']);
            }
        }
    }


}