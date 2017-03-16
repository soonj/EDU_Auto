<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;

/**
 * Class Vst
 * @package app\index\controller
 * 访客控制器，修改访客信息，并提交数据库
 */
class Vst extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        if ($role != 4){
            $this->error('权限不正确');
        }
    }

    //访客主页
    public function index($uname , $func = null)
    {
        //访客是否登录验证
        parent::verify($uname);

        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }

        return $this->fetch('v_index');
    }

    //访客信息添加
    public function profile()
    {
        return $this->fetch('profile');
    }

    //访客修改个人信息
    public function Fixinfo()
    {
        $data = db('profile')->where('pid', $_SESSION['think']['uid'])->find();
        $this->assign('userinfo', $data);
        return $this->fetch('Fixinfo');
        
    }

    //
    public function homework()
    {
        $stu_info = db('profile')
                        ->where('pid', $_SESSION['think']['uid'])
                        ->find();

        $this->assign('class', $class); 

        //如果有正在布置的作业，获取之
        if (!empty($_SESSION['think']['workcacheid'])) {
                $data = db('homeworkcache')
                        ->where('keyid', $_SESSION['think']['workcacheid'])
                        ->where('del_work', 1)
                        ->find();
            if ($data) {
               $this->assign('homeworkcache', $data); 
            }
        }
        return $this->fetch('homework');
    }

    public function doadd($data)
    {

    }
}