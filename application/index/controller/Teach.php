<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
/**
 * Class Teach
 * @package app\index\controller
 * 教师控制器
 */
class Teach extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        if ($role != 2){
            $this->error('权限不正确');
        }
        //$Session::set('name', "$name");
    }

    public function index($uname , $func = null)
    {
        //访客是否登录验证
        parent::verify($uname);

        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('bgd_index');
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