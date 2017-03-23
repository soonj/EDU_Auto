<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;

/**
 * Class Assis
 * @package app\index\controller
 * 助教控制器
 */
class Assis extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        parent::verify('assis');
    }

    public function index($func)
    {

        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('index');
    }

    public function announce()
    {
        return $this->fetch('announce');
    }

    public function mywork()
    {
        return $this->fetch('mywork');
    }

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
        $homework = Loader::model('Homework')->showHomework();

        $homeworkNum = Loader::model('Homework')->homeworkNum();

        $teach_info = db('profile')
            ->where('pid', $_SESSION['think']['uid'])
            ->find();

        //处理拼接的班级字符串
        $class = explode('/' , $teach_info['class']);
        //dump($class);
        $this->assign('class', $class);
        $this->assign('homeworkNum', $homeworkNum);
        $this->assign('homework', $homework);
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
            } elseif ($sdata['subject_type'] == 'deltimu') {
                $homework = Loader::model('Homework')->deltimu($sdata);
            } else {
                $homework = Loader::model('Homework')->setSubject($sdata);
            }
        }

    }

    public function setProfile()
    {
        $sdata = input('post.');

        $data = Loader::model('Profile')->getProfile($_SESSION['think']['uid']);

        dump($data['pid']);
        if (!empty($data['pid'])) {
            $profile = Loader::model('Profile')->updateProfile($sdata, 'pid', $_SESSION['think']['uid']);
        } else {
            $data = Request::instance()->post();
            Loader::model('Profile')->setProfile($sdata);
        }
    }

    public function upload()
    {
        $data = Loader::model('Res')->getRes();
        $this->assign('res' , $data);
        return $this->fetch('upload');

    }

    public function forms()
    {
        return $this->fetch('forms');
    }

    public function fixinfo()
    {
        $data = db('profile')->where('pid', $_SESSION['think']['uid'])->find();
        $this->assign('userinfo', $data);
        return $this->fetch('fixinfo');

    }

    //展示对应的作业
    public function tables()
    {
        if (empty($_GET)) {
            return $this->mywork();
        }
        $info_homework = Loader::model('Homework')->where('hid', $_GET['hid'])->select();
        $list_work = Loader::model('Homework')->where('dowork', $_GET['hid'])->where('class_id', $_GET['class'])->select();

        $this->assign('info', $info_homework);
        $this->assign('worklist', $list_work);
        return $this->fetch('tables');
    }

    //展示学生请假页面
    public function bootstrapelements()
    {
        $teach_info = db('profile')
            ->where('pid', $_SESSION['think']['uid'])
            ->find();

        //处理拼接的班级字符串
        $class = explode('/' , $teach_info['class']);

        foreach($class as $cla) {
            $data[] = Loader::model('Qingjia')->qingjialist($cla);

            $list[] = Loader::model('Qingjia')->qingjiaall($cla);
        }

        $this->assign('qingjialist', $list);
        $this->assign('qingjia', $data);

        return $this->fetch('bootstrapelements');
    }

    //处理学生请假方法
    public function shenpi()
    {
        $sdata = input('post.');

        $data = Loader::model('Qingjia')->shenpi($sdata);

    }
}