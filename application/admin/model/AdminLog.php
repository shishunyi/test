<?php

namespace app\admin\model;
class AdminLog extends \think\Model
{
    public static function instance()
    {
        return new self();
    }

    public function insertlog($id,$state)
    {
        $user = $this->find($id);
        return $this->save([
                    'aid'=>$user['aid'],
                    'logip'=>request()->ip(),
                    'state'=>$state,
                    'createtime'=>time()
        ]);
    }
}