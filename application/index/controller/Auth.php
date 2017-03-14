<?php
namespace app\index\controller;

use think\Controller;
use think\Cookie;
use think\Loader;
use think\Session;

/**
 * Class Auth
 * @package app\index\controller
 * 登录注册验证控制器
 */
class Auth extends Controller
{

    //注册
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

        if ($result[0]==1){
            //注册成功
            Cookie::set('uname' , $result['uname'] , 3600);
            Session::set('uid' , $result['uid']);

            //默认跳转至访客页面
            $this->success($result['msg'] , '/vst/'.$result['uname']);
        }else {
            //注册失败
            $this->error($result['msg']);
        }
    }

    //登录
    public function login()
    {
        $loginData = input('post.');

        $data = [
            'uname' =>$loginData['uname'],
            'upwd'  =>$loginData['upwd'],
            'hidden'=>$loginData['hidden'],
        ];

        $result = Loader::model('Auth')->auth($data);
        if ($result[0] == 0){
            Cookie::set('uname' , $result['uname'] , 3600);
            Session::set('uid' , $result['uid']);
            Session::set('uname' , $result['uname']);
            switch ($result['role']){
                case 0:
                    $this->success($result['msg'] , '/stu/'.$result['uname']);
                    break;
                case 1:
                    $this->success($result['msg'] , '/assis/'.$result['uname']);
                    break;
                case 2:
                    $this->success($result['msg'] , '/teach/'.$result['uname']);
                    break;
                case 3:
                    $this->success($result['msg'] , '/admin/'.$result['uname']);
                    break;
                case 4:
                    $this->success($result['msg'] , '/vst/'.$result['uname']);
            }
        }else{
            $this->error($result['msg']);
        }

    }

    //退出登录
    public function logout()
    {
        Cookie::delete('uname');
    }
}
