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
    }


    public function index($uname , $func = null)
    {
        //访客是否登录验证
        //dump($_SESSION);
        parent::verify($uname);
        
        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('index');
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
	

    public function blankpage()
    {
        return $this->fetch('blankpage');
    }

    public function bootstrapelements()
    {
        return $this->fetch('bootstrapelements');
    }

    public function bootstrapgrid()
    {
        return $this->fetch('bootstrapgrid');
    }

    public function mywork()
    {
        return $this->fetch('mywork');
    }

    //展示助教权限页面
    public function charts()
    {
        $class = Loader::model('user')->getUser($_SESSION['think']['uid']);

        $classarr = explode('/', $class['class']);

        //按不同班级处理学生数据
        foreach($classarr as $value) {
            $user = Loader::model('user')->where('role', 0)->where('class', $value)->select();
            foreach($user as $val) {
                $studens[$value][] = $val;
            }
        }

        //获取老师的数据
        $teach = Loader::model('user')->where('role', 2)->select();

        $this->assign('teach', $teach);
        $this->assign('class', $studens);

        return $this->fetch('charts');
    }

    //修改助教权限部分
    public function docharts()
    {
        $sdata = input('post.');
        //dump($sdata);
        //die;
        if ($sdata['type'] == 'teach') {
            $teachdata = explode('/', $sdata['class']);

            $teach = Loader::model('user')->charts($teachdata[1], $teachdata[0]);

            $update = Loader::model('zhujiao')->updatezhujiao($teachdata[1], $teachdata[0]);
        } else {
            $studata = explode('/', $sdata['type']);

            //dump($studata[1]);
            //die;

            $teach = Loader::model('user')->charts($sdata['uid'], $studata[0], $studata[1]);

            $update = Loader::model('zhujiao')->updatezhujiao($sdata['uid'], $studata[0], $studata[1]);
        }

    }
	
    public function fixinfo()
    {
        $data = db('profile')->where('pid', $_SESSION['think']['uid'])->find();
        $this->assign('userinfo', $data);
        return $this->fetch('Fixinfo');
        
    }
	
    public function forms()
    {
        return $this->fetch('forms');
    }

    public function tables()
    {
        return $this->fetch('tables');
    }

}