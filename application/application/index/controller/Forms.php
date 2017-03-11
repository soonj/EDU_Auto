<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use app\index\model\Profile;
use think\Validate;
use think\Loader;
use think\Session;
use think\Controller;


class Forms extends Controller
{
    public function Forms()
    {
        return $this->fetch();
    }
}