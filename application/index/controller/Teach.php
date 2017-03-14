<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Model;

class Teach extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        //var_dump($role);die;
        if ($role != 2){
            $this->error('权限不正确');
        }
        //$Session::set('name', "$name");
    }

    public function bgd_index($uname)
    {
        //TODO:展示教师用户页

        return $this->fetch();
    }

    public function homework($uname)
    {
        
        return $this->fetch();
    }

    public function Blankpage()
    {
        return $this->fetch();
    }

    public function Bootstrapelements()
    {
        return $this->fetch();
    }

    public function Bootstrapgrid()
    {
        return $this->fetch();
    }

    public function Mywork()
    {
        return $this->fetch();
    }

    public function charts()
    {
        return $this->fetch();
    }

    public function Fixinfo()
    {
        
        $data = db('profile')->where('pid', $_SESSION['think']['uid'])->find();
        $this->assign('userinfo', $data);
        return $this->fetch();
    }

    public function Forms()
    {
        return $this->fetch();
    }

    public function Tables()
    {
        return $this->fetch();
    }

}