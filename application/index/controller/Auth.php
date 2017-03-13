<?php
namespace app\index\controller;


use app\index\model\Auth as UserAuth;
use think\Controller;
use think\Request;
use think\Loader;

class Auth extends Controller
{


    public function reg()
    {

        $regData = input('post.');
        $data = [
            'uname' =>$regData['uname'],
            'upwd'  =>$regData['upwd'],
            'repwd' =>$regData['repwd'],
            'hidden'=>$regData['hidden'],
        ];
        $result = Loader::model('Auth')->auth($data);

        return $result;
    }

    public function login()
    {
        $loginData = input('post.');

        $data = [
            'uname' =>$loginData['uname'],
            'upwd'  =>$loginData['upwd'],
            'hidden'=>$loginData['hidden'],
        ];

        $result = Loader::model('Auth')->auth($data);
        return $result;
    }
}
