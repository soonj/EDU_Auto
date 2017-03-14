<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;

/**
 * Class Stu
 * @package app\index\controller
 * 学生控制器
 */
class Stu extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        if ($role != 0){
            $this->error('权限不正确');
        }
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

    public function homework()
    {
        $this->fetch('Homework');
    }

    public function profile()
    {
        $this->fetch('profile');
    }

    public function res()
    {
        $this->fetch('res');
    }
}