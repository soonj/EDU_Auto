<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Request;

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
        parent::verify(get_class());
    }

    public function index($func = null)
    {
        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('index');
    }

    //ajax轮询返回通知内容
    public function ajaxGetNotice()
    {
        //此处为获取所有通知，返回类型为数组，数组中包含对应的对象 `array(obj()->content)`
        $data = Loader::controller('Notice')->getNotices($this->uid);
        echo json_encode($data);
        exit();
    }

    //学生写作业
    private function homework()
    {
        $userinfo = Loader::model('user')->getUser($_SESSION['think']['uid']);
        $data = Loader::model('Homework')->getHomework($userinfo);

        $this->assign('homework', $data);

        return $this->fetch('homework');
    }

    private function charts()
    {
        return $this->fetch('charts');
    }

    //提交完成作业
    public function doHomework()
    {
        $sdata = input('post.');
        
        $pushhomework = Loader::model('Homework')->pushwork($sdata);
    }

    //查看用户详情
    protected function profile()
    {
        $data = Loader::model('Profile')->getProfile($this->uid);
        $this->assign('userinfo', $data);

        return $this->fetch('fixinfo');
    }

    //修改用户详情
    protected function setProfile()
    {
        $data = Request::instance()->post();
        Loader::model('Profile')->setProfile($data);
    }

    //查看用户资源
    private function res()
    {
        $data = Loader::model('Res')->getRes();
        $this->assign('res' , $data);
        return $this->fetch('res');
    }
}