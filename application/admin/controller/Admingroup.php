<?php

namespace app\admin\controller;


class Admingroup extends Common {

    public function index()
    {
        if(Request()->isAjax()) {
            $where = [];


            if (request()->param('id')) {
                $where[] = ['id','=',request()->param('id')];
            }
            if (request()->param('title')) {
                $t = request()->param('title');
                $where[] = ['id|groupname','like','%'.$t.'%'];
            }
            $res = model('GroupChat')
                //->alias('a')
                ->with('member')
                ->withCount('chatmember')
                ->where($where)
                ->page(request()
                ->param('page'),request()->param('limits'))
                ->select();
            $rescount = model('GroupChat')->where($where)->count();
            if($rescount % request()->param('limits') == 0){
                $rescount = intval($rescount / request()->param('limits'));
            }else{
                $rescount = intval($rescount / request()->param('limits')) + 1;
            }
            return json(['code'=>0,'data'=>['data'=>$res,'datacount'=> $rescount]]);
        }
        return view();
    }



    public function savegroupname($id,$name)
    {
        if(!model('GroupChat')->where('groupname','=',$name)->where('id','<>',$id)->find()){
            $res = model('GroupChat')->save([
                'groupname'=>$name
            ],['id'=>$id]);
            if($res){
                return json(['code'=>0,'msg'=>'成功！']);
            }else{
                return json(['code'=>1,'msg'=>'失败！']);
            }
        }else{
            return json(['code'=>1,'msg'=>'此群组名称已存在！']);
        }
    }
}