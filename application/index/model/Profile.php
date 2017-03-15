<?php
namespace app\index\model;

use think\Model;

class Profile extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }
    //更新个人信息方法
    public function updateProfile($data)
    {
    	//去除数组中空值得元素
    	$newdata=array_filter ($data);

    	$update = db('profile')
                    ->where('pid',$_SESSION['think']['uid'])
                    ->update($newdata);
        if (!$update) {
            return false;
        } else {
            return true;
        }
    }
}