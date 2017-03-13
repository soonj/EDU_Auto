<?php
namespace app\index\controller;

use think\Controller;

class Signin extends Controller
{
    public function signin()
    {
        return $this->fetch('/index/signin');
    }
}