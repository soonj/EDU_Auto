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
    protected $notice;
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        if ($role != 0){
            $this->error('权限不正确');
        }

        //此处为获取所有通知，类型为数组，数组中包含对应的对象`array(obj()->content)`
        $this->notice = Loader::controller('Notice')->getNotices($this->uid);
    }

    public function index($uname , $func = null)
    {
        //访客是否登录验证
        parent::verify($uname);

        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }
        $this->assign('notice', $this->notice);
        return $this->fetch('bgd_index');
    }

    //查看学生作业
    private function homework()
    {
        $data = Loader::model('Homework')->getHomework($this->uid);
        $this->fetch('homework' , $data);
    }

    //提交完成作业
    private function doHomework()
    {
        $data = input('post');
        Loader::model('Homework')->doHomework($data);
    }

    //查看用户详情
    protected function profile()
    {
        $data = Loader::model('Profile')->getProfile($this->uid);
        $this->assign('userinfo', $data);

        $this->fetch('Fixinfo');
    }

    //修改用户详情
    protected function setProfile()
    {
        $data = input('post');
        Loader::model('Profile')->setProfile($data);
    }

    //查看用户资源
    private function res()
    {
        $data = Loader::model('Res')->getRes($this->uid);
        $this->assign('ures' , $data);
        $this->fetch('res');
    }
}