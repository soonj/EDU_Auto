<?php
namespace app\index\controller;

use app\common\controller\Common;


class Index extends Common
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        return $this->fetch('signin');
    }

    public function signin()
    {
        return $this->fetch('signin');
    }
}
