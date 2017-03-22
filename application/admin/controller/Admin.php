<?php
namespace app\admin\controller;


use app\index\model\Res;
use app\index\controller\Upload;
use app\admin\controller\ImportExcel;
use think\Loader;

class Admin extends Auth
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index($func = null)
    {
        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch();
    }

    //网站浏览/登录记录
    public function Log()
    {

    }

    //网站信息查看和设置
    public function settings()
    {

    }

    //最新上传
    public function viewRes()
    {
        $res= new Res();
        $data = $res->getRes();
        $this->assign('res' , $data);

        return $this->fetch();
    }

    //显示上传excel页面
    public function uploadExcel()
    {
        return $this->fetch('upload');
    }

    //初始化学生
    public function initStu()
    {
        $path = Loader::controller('Upload')->uploadTmp();
        $importExcel = Loader::controller('ImportExcel')->importExcel($path);
        return $importExcel;
    }

    //学生管理（教师管理）
    public function manage()
    {
        $list = Loader::model('Profile')->getProfile();
        $this->assign('list' , $list);
        return $this->fetch('manage');
    }

    //执行修改
    public function domanage()
    {
        if (! request()->isAjax()){
            $this->error('Request Type Error');
        }

        $request = request()->param();
        $data = model('User')->$request['action']($request);
        return $data;
    }

    //对教师发送通知
    public function sendMessage()
    {
        return $this->fetch('announce');
    }
    //课程管理
    public function course()
    {

    }

}