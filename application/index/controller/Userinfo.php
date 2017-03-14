<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Model;

class Userinfo extends Common
{
    public function Userinfo()
    {
        $fixdata = input('post.');

        $profile = Loader::model('Profile')->updateProfile($fixdata);

        $uname = $_SESSION['think']['uname'];

        if ($profile) {
            echo $result = json_encode($uname);
        }
    }
}



