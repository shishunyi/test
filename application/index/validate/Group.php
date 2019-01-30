<?php

namespace app\index\validate;

use think\Validate;

class Group extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'groupname'=>'require|min:2|max:20',
        'groupheadimg'=>'require',

    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [

        'groupname.require'=>'领地名称必须输入',
        'groupname.min'=>'领地名称最短两个字符',
        'groupname.max'=>'领地名称最长两个字符',
        'groupheadimg'=>'领地头像必须上传',
    ];
}
