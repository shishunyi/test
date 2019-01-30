<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'username'=>'require|min:6|max:20|alphaNum',
        'password'=>'require|min:6|max:20|alphaNum',
        'gameid'=>'require|min:3|max:20|number',
        'nickname'=>'require|min:2|max:20',
        'translate'=>'require',
        'headimgurl'=>'require',

    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'username.require'=>'登录账号必须输入',
        'username.min'=>'登录账号至少6个字符',
        'username.max'=>'登录账号最多20个字符',
        'username.alphaNum'=>'登录账号只能字母和数字',
        'password.require'=>'登录密码必须输入',
        'password.min'=>'登录密码至少6位数',
        'password.max'=>'登录密码最多20位数',
        'password.alphaNum'=>'密码只能字母和数字',
        'gameid.require'=>'游戏ID必须输入',
        'gameid.min'=>'游戏ID至少3个字符',
        'gameid.max'=>'游戏ID至多20个字符',
        'gameid.number'=>'游戏ID只能数字',
        'nickname.require'=>'昵称必须输入',
        'nickname.min'=>'昵称至少2个字符',
        'nickname.max'=>'昵称至多20个字符',
        'translate.require'=>'名片二维码必须上传',
        'headimgurl.require'=>'个人头像必须上传',



    ];
}
