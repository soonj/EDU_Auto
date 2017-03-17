<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Request;
use think\Session;

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
    }

    public function index($uname , $func = null)
    {
        //访客是否登录验证
        parent::verify($uname);

        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('index');
    }

    //发布通知页面显示
    public function announce()
    {
        return $this->fetch('announce');
    }

    //发布全站通知，旋转吧小陀螺！！
    public function doAnnounce()
    {
        $data = Request::instance()->post();
        $data['sender_id'] = $this->uid;
        $result = Loader::model('Notice')->announce($data);
        if ($result){
            $this->success('发布成功');
        }
    }

    public function homework()
    {
        $teach_info = db('profile')
                        ->where('pid', $_SESSION['think']['uid'])
                        ->find();
        // 查询单个数据

        $class = explode('/' , $teach_info['class']);
        //dump($class);
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

    public function doHomework()
    {
        $sdata = input('post.');

        if (!empty($sdata['subject_type'])) {
            if ($sdata['subject_type'] == 'del_work') {
                $homework = Loader::model('Homework')->delHomework();
            } elseif ($sdata['subject_type'] == 'send_work') {
                $homework = Loader::model('Homework')->sendHomework($sdata);
            } else {
                $homework = Loader::model('Homework')->setSubject($sdata);
            }
        }

    }

    //显示上传页面，查看资源库
    public function upload()
    {
        $res = Loader::model('Res')->getRes();
        $this->assign('res' , $res);
        return $this->fetch('upload');
    }

    //上传文件
    public function doupload()
    {
        $files = request()->file('file-zh');
        $title = Request::instance()->post();
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
            //上传成功
                $data = [
                    'path'      => ROOT_PATH . 'public' . DS . 'uploads\\' . $info->getFilename(),
                    'uid'       => $this->uid,
                    'filename'  => $info->getFilename(),
                    'type'      => $info->getExtension(),
                    'title'     => $title['title'],
                ];
                Loader::model('Res')->upload($data);
                echo json_encode($title['title']);
            }else{
            // 上传失败获取错误信息
                echo json_encode($file->getError());
            }
        }
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
        return $this->fetch('Fixinfo');

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