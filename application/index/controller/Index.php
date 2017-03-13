<?php
namespace app\index\controller;


class Index extends \think\Controller
{
    public function index()
    {
        return $this->fetch('index');
    }

    public function work()
    {
        return $this->fetch('work');
    }

    public function signup()
    {
        return $this->fetch('signup');
    }
}
