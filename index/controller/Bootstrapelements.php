<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use app\index\model\Profile;
use think\Validate;
use think\Loader;
use think\Session;
use think\Controller;


class Bootstrapelements extends Controller
{
    public function Bootstrapelements()
    {
        return $this->fetch();
    }
}