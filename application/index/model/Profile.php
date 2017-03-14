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
    	 $update = db('profile')
                    ->where('pid',$_SESSION['think']['uid'])
                    ->update($data);
        if (!$update) {
            return false;
        } else {
            //echo $result = json_encode(['更新成功']);
            return true;
        }
    }
}