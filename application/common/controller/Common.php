<?php
namespace app\common\controller;

use think\Controller;
use think\Cookie;
use think\Session;

class Common extends Controller
{
    protected $uid;
    protected $uname;
    public function _initialize()
    {

        if( !Cookie::has('uname') || !Session::has('uid')) {
            $this->error('Please login first', '/signin');
        }

        $this->uid = Session::get('uid');
        $this->uname = Session::get('uname');
    }

    public function verify($uname)
    {
        if( $uname != $this->uname) {
            $this->error('Please login first', '/signin');
        }
    }
}