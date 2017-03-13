<?php
namespace app\index\controller;

use think\Controller;

class Signup extends Controller
{
    public function signup()
    {
        return $this->fetch('/index/signup');
    }
}