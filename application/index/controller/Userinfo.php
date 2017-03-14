<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Model;

class Userinfo extends Common
{
    public function Userinfo()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        if ($role != 2){
            $this->error('权限不正确');
        }
        $fixdata = input('post.');
        $data = [
            'fix_phone' =>$fixdata['fix_phone'],
            'fix_qq'  =>$fixdata['fix_qq'],
            'fix_add' =>$fixdata['fix_add'],
            'fix_dizhi'=>$fixdata['fix_dizhi'],
            'fix_xueyuan' =>$fixdata['fix_xueyuan'],
            'fix_kemu'  =>$fixdata['fix_kemu'],
            'fix_class' =>$fixdata['fix_class'],
        ];
        
        //echo $result = json_encode(['11111111111111']);
        //die;
    }
}



