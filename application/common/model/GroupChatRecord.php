<?php

namespace app\common\model;
use think\Exception;

class GroupChatRecord extends \think\Model{




    public static function instance()
    {
        return new self();
    }


    public function member()
    {
        return $this->belongsTo('Member','uid','id');
    }

    public function getCreatetimeAttr($val)
    {
        return date('Y-m-d H:i:s',$val);
    }

}