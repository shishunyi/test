<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app\api\controller;

use GatewayWorker\Lib\Gateway;
use Workerman\Worker;
use think\Db;
/**
 * Worker 命令行服务类
 */
class Socket
{

    protected $db;
    /**
     * onWorkerStart 事件回调
     * 当businessWorker进程启动时触发。每个进程生命周期内都只会触发一次
     *
     * @access public
     * @param  \Workerman\Worker    $businessWorker
     * @return void
     */
    public static function onWorkerStart(Worker $businessWorker)
    {
        global $db;
       $db = new Db();

    }

    /**
     * onConnect 事件回调
     * 当客户端连接上gateway进程时(TCP三次握手完毕时)触发
     *
     * @access public
     * @param  int       $client_id
     * @return void
     */
    public static function onConnect($client_id)
    {
        //Gateway::sendToCurrentClient("Your client_id is $client_id");
    }

    /**
     * onWebSocketConnect 事件回调
     * 当客户端连接上gateway完成websocket握手时触发
     *
     * @param  integer  $client_id 断开连接的客户端client_id
     * @param  mixed    $data
     * @return void
     */
    public static function onWebSocketConnect($client_id, $data)
    {


    }

    /**
     * onMessage 事件回调
     * 当客户端发来数据(Gateway进程收到数据)后触发
     *
     * @access public
     * @param  int       $client_id
     * @param  mixed     $data
     * @return void
     */
    public static function onMessage($client_id, $data)
    {
        try{

            $data = json_decode($data,true);

            switch($data['type'])
            {
                case 'init':
                    self::init($data['uid'],$client_id,$data['gid']);        //用户初始化  创建群组信息
                    break;
                case 'sendmsg':
                    self::sendmsg($client_id,$data['gid'],$data['msgtype'],$data['msgdata']);       //消息接收
                break;
                default:
                    $msg = ['type'=>'errmsg','msg'=>'无法识别的message'];
                    Gateway::sendToClient($client_id, json_encode($msg));
            }

        }catch (\Exception $e){
            Gateway::sendToClient($client_id, json_encode(['type'=>'errmsg','msg'=>$e->getMessage(),'line'=>$e->getLine()]));
        }
    }

    /**
     * onClose 事件回调 当用户断开连接时触发的方法
     *
     * @param  integer $client_id 断开连接的客户端client_id
     * @return void
     */
    public static function onClose($client_id)
    {
        //$uid = Gateway::getUidByClientId($client_id);
        $uid = session($client_id);
        echo "\n".self::userinfo($uid)['nickname']."退出\n";

        if($uid){
            foreach (self::getGroupList($uid) as $k => $v){

                Gateway::sendToGroup($v['gid'],self::sendToClientEventMsg('logout',$v['gid'],$uid,'用户退出群聊！',time()));
                //群组在线人数更新
                Gateway::sendToGroup($v['gid'],self::sendToClientEventMsg('groupuserupdate',$v['gid'],$uid,Gateway::getUidCountByGroup($v['gid']).'/'.self::getGroupUserCount($v['gid']),time()));
            }
        }
    }

    /**
     * onWorkerStop 事件回调
     * 当businessWorker进程退出时触发。每个进程生命周期内都只会触发一次。
     *
     * @param  \Workerman\Worker    $businessWorker
     * @return void
     */
    public static function onWorkerStop(Worker $businessWorker)
    {
        echo "WorkerStop\n";
    }

    /*
     * 用户进入初始化所有群组信息
     *
     * */
    public static function init($uid,$client_id,$gid)
    {
        //绑定UID
        try{

            $uid = self::userinfo($uid,'session_key')['id'];
            session($client_id,$uid);         //onClose回调无法调用getUidByClientId  session处理
            Gateway::bindUid($client_id, $uid);
            echo "\n用户：(".self::userinfo($uid)['nickname'].")初始化\n";
            //绑定GROUPID

            Gateway::joinGroup($client_id, $gid);

            Gateway::sendToClient($client_id, json_encode(['type'=>'init','msg'=>'初始化成功']));

            //群组在线人数更新
            Gateway::sendToGroup($gid,self::sendToClientEventMsg('groupuserupdate',$gid,$uid,Gateway::getUidCountByGroup($gid).'/'.self::getGroupUserCount($gid),time()));

            //群组发送上线消息
            Gateway::sendToGroup($gid,self::sendToClientmsg($gid,$uid,'1','我上线了！',time()));

        }catch (\Exception $e){
            Gateway::sendToClient($client_id, json_encode(['type'=>'errmsg','msg'=>$e->getMessage()]));
        }

    }
    /*
     * 消息接收处理
     *
     * */
    public static function sendmsg($client_id,$gid,$msgtype,$msgdata)
    {

        global $db;
        $timer = time();
        $uid = Gateway::getUidByClientId($client_id);
        if(!$uid){
            Gateway::sendToClient($client_id,self::sendToClientEventMsg('groupuserout',$gid,0,'你已不在当前领地！',time()));

            return false;
        }
        if(self::onLineCheck($client_id,$gid,$uid)){

            echo "\n用户：(".self::userinfo($uid)['nickname'].")在群组(".self::groupinfo($gid)['groupname'].")发送".self::msgTypeToText($msgtype)."类型消息：(".$msgdata.")\n";

            Gateway::sendToGroup($gid,self::sendToClientmsg($gid,$uid,$msgtype,$msgdata,$timer));
        }
    }

    /*
     * 用户群组是否在群组检测
     * */

    public static function onLineCheck($client_id,$gid,$uid)
    {
        global $db;
        $grouplist = Gateway::getClientIdListByGroup($gid);
        foreach ($grouplist as $k => $v)
        {
            $uuid = Gateway::getUidByClientId($v);

            if(!$db::table('qq_group_member')->where(['gid'=>$gid,'uid'=>$uuid])->find()){
                echo "\n".self::userinfo($uuid)['nickname']."已不再群组".self::groupinfo($gid)['groupname']."\n";
                Gateway::sendToClient($v,self::sendToClientEventMsg('groupuserout',$gid,$uuid,'你已不在当前领地！',time()));

                Gateway::unbindUid($v,$uuid);        //用户解绑
                Gateway::leaveGroup($v,$gid);


            }
        }

        return true;

    }










    /*
     * 用户信息  key
     * */

    public static function userinfo($uid,$key = 'id')
    {
        global $db;

        $user = $db::table('qq_member')->where([$key=>$uid])->find();
        if(!$user){
            throw new \Exception('未找到用户信息！');
        }
        return $user;
    }
    /*
     * 群组信息
     *
     * */
    public static function groupinfo($gid)
    {
        global $db;
        $group = $db::table('qq_group_chat')->where(['id'=>$gid])->find();
        if(!$group){
            throw new \Exception('未找到群组信息！');
        }
        return $group;
    }

    /*
     * 获取所有群组列表
     * */
    public static function getGroupList($uid)
    {
        global $db;
        return $db::table('qq_group_member')->where(['uid'=>$uid,'state'=>'1'])->select();
    }


    /*
     * 群组总人数
     * */
    public static function getGroupUserCount($gid)
    {
        global $db;
        return $db::table('qq_group_member')->where(['gid'=>$gid,'state'=>'1'])->count();
    }
    public static function msgTypeToText($typeid)
    {
        switch($typeid){
            case '1':
                return '文本';
                break;
            case '2':
                return '图片';
                break;
            default:
                return '未知';
        }
    }

    public static function sendToClientmsg($gid,$uid,$msgtype,$msgdata,$timer)
    {
        global $db;
        $db::table('qq_group_chat_record')->insert([
            'uid'=>$uid,
            'gid'=>$gid,
            'msgtype'=>$msgtype,
            'msgdata'=>$msgdata,
            'createtime'=>$timer
        ]);
        return json_encode([
            'type'=>'msg',
            'gid'=>$gid,
            'uid'=>$uid,
            'member'=>self::userinfo($uid),
            'msgtype'=>$msgtype,
            'msgdata'=>$msgdata,
            'createtime' => date('Y-m-d H:i:s',$timer)
        ]);
    }

    public static function sendToClientEventMsg($type,$gid,$uid,$msgdata,$timer)
    {
        return json_encode([
            'type'=>$type,
            'gid'=>$gid,
            'uid'=>$uid ?? '当前用户',
            'member'=>$uid ? self::userinfo($uid) : '当前用户',
            'msgdata'=>$msgdata,
            'createtime' => date('Y-m-d H:i:s',$timer)
        ]);
    }
}
