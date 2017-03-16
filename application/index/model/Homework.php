<?php
namespace app\index\model;

use think\Model;
use think\Cookie;
use think\Loader;
use think\Session;

class Homework extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    //学生载入作业方法！
    public function stu_homework()
    {
        echo 11111111;
    }

    //发布作业方法
    public function sendHomework($data)
    {
    	if (!empty($_SESSION['think']['workcacheid'])) {
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('del_work', 1)
                    ->select();
            if ($cache) {
                $homework = true;
            } else {
                $homework = false;
            }
        } else {
            $homework = false;
        }
        if(!empty($data['class'])) {
            $string = join('/', $data['class']);
        }

        $senddata['end_time'] = $data['work_time']*3600*24 + time();
        $senddata['class_id'] = $string;
        $senddata['content'] = '<div class="jumbotron">'.$cache[0]['xuanze'].$cache[0]['panduan'].$cache[0]['jianda'].'</div>';
        $senddata['teach_id'] = $_SESSION['think']['uid'];

        $result = db('homework')->insert($senddata);
        if ($result) {
            return true;
        } else {
            return false;
        }
        
    }

    //删除作业方法
    public function delHomework()
    {
        $deldata = ['del_work' => '0'];
        $result = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->update($deldata);
    }

    //编辑作业方法
    public function setSubject($data)
    {
        //Session::delete('workcacheid', 'think');

        //判断这个老师有没有正在布置的作业！
        if (!empty($_SESSION['think']['workcacheid'])) {
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('del_work', 1)
                    ->select();
            if ($cache) {
                $homework = true;
            } else {
                $homework = false;
            }
        } else {
            $homework = false;
        }
        

        //取出数组中的题目类型和uid
        $key = $data['subject_type'];
        $uid = $_SESSION['think']['uid'];

        //如果session中没有缓存元素，说明没有近期没发布作业，重新
        if (!$homework) {

            //生成作业更新Id
            $keyid = ceil($uid + (time() / 2));

            //如果是选择题，需要输出选项
            if ($key == 'xuanze') {
                $new_timu = '<div class="table-responsive" id="xuanze"><h4>'.$data['pick_main'].'</h4><h4>'.$data['pick_1'].'</h4><h4>'.$data['pick_2'].'</h4><h4>'.$data['pick_3'].'</h4><h4>'.$data['pick_4'].'</h4></div>';
                $send = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid, $key.'num' => 1];
            //如果是时间，去掉题目数量字段
            } elseif($key == 'title'){
                $new_timu =$data['pick_main'];
                $send = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid];
            } else {
                $new_timu = '<div class="table-responsive" id="xuanze"><h4>'.$data['pick_main'].'</h4></div>';
                $send = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid, $key.'num' => 1];
            }
            
            $result = db('homeworkcache')->insert($send);
            if ($result) {
                Session::set('workcacheid' , $keyid);
                return true;
            } else {
                return false;
            }
        } else {
            //条件查询
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->select();

            //更新一个新的缓存Id
            $keyid = ceil($uid + (time() / 2));

            //获取题目数量，并在对应的项目上+1s
            if ($key <> 'title') {
                $string = $key.'num';
                $num = $cache[0][$string] + 1;
            }

            if (empty($cache[0][$key])) {
                if ($key == 'xuanze') {
                    $new_timu = '<div class="table-responsive" id="xuanze"><h4>'.$data['pick_main'].'</h4><h4>'.$data['pick_1'].'</h4><h4>'.$data['pick_2'].'</h4><h4>'.$data['pick_3'].'</h4><h4>'.$data['pick_4'].'</h4></div>';
                    $newdata = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid, $key.'num' => $num];
                } elseif ($key == 'title') {
                    $new_timu =$data['pick_main'];
                    $newdata = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid];
                } else {
                    $new_timu = '<div class="table-responsive" id="xuanze"><h4>'.$data['pick_main'].'</h4></div>';
                    $newdata = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid, $key.'num' => $num];
                }
            } else {
                if ($key == 'xuanze') {
                    $new_timu = $cache[0][$key].'<div class="table-responsive" id="xuanze"><h4>'.$data['pick_main'].'</h4><h4>'.$data['pick_1'].'</h4><h4>'.$data['pick_2'].'</h4><h4>'.$data['pick_3'].'</h4><h4>'.$data['pick_4'].'</h4></div>';
                    $newdata = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid, $key.'num' => $num];
                } elseif($key == 'title') {
                    $new_timu =$data['pick_main'];
                    $newdata = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid];
                } else {
                    $new_timu = $cache[0][$key].'<div class="table-responsive" id="xuanze"><h4>'.$data['pick_main'].'</h4></div>';
                    $newdata = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid, $key.'num' => $num];
                }
            }

            //执行更新语句
            $result = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->update($newdata);
            //判断语句执行结果
            if ($result) {
                Session::set('workcacheid' , $keyid);
                return true;
            } else {
                return false;
            }
        }
    }
}
