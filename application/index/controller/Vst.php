<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Request;

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

        return $this->fetch('bgd_index');
    }

    //访客信息添加界面显示
    protected function profile()
    {
        return $this->fetch('profile');
    }

    //提交信息添加
    public function setProfile()
    {
        $data = Request::instance()->post();
//         输入信息验证
//        $validate = Loader::validate('Profile');
//        if (!$validate->check($data)){
//            dump($validate->getError());
//            $this->error();
//        }
        $result = Loader::model('Profile')->setProfile($data);
        if ($result){
            Loader::model('Role')->setRole(['role'=>'0'] , $this->uid);
            Loader::model('Notice')->regAnnounce($this->uid);
            $this->success('修改成功' , '/stu/'.$this->uname);
        }else{
            $this->error('修改失败');
        }

    }
}