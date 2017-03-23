<?php
namespace app\index\model;

use think\Model;
use think\Cookie;
use think\Loader;
use think\Session;

class Qingjia extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function qingjia($data)
    {  
        $ctime = strtotime($data['ctime']);
        $etime = strtotime($data['etime']);
        $now = time();

        $maxtime = time() + 60*60*24*7;
        if ($now > $ctime) {
            echo $msg = false;
            exit;

        }
        if ($etime > $maxtime) {
            echo $msg = false;
            exit;

        }
        $data['ctime'] = $ctime;
        $data['etime'] = $etime;

        $result = db('qingjia')->insertGetId($data);

        if ($result) {
            echo $msg = true;
            exit;
            
        }
    }

    public function getqingjia()
    {  
        $data = db('qingjia')
                ->where('uid', $_SESSION['think']['uid'])
                ->select();
        return $data;
    }

    //教师查看请假列表
    public function qingjialist($class, $num = 0)
    {  
        $data = db('qingjia')
                ->where('class', $class)
                ->where('type', $num)
                ->select();
        return $data;
    }

    public function qingjiaall($class)
    {  
        $data = db('qingjia')
                ->where('class', $class)
                ->select();
        return $data;
    }

    public function shenpi($data)
    {  
        $type['type']=$data['type'];
        $result = db('qingjia')
                    ->where('kid',$data['kid'])
                    ->update($type);
        return $data;
    }
}
