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
        self::logout();
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
            Session::set('uname' , $result['uname']);
            Session::set('role' , $result['role']);

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
        self::logout();
        $loginData = input('post.');

        $data = [
            'uname' =>$loginData['uname'],
            'upwd'  =>$loginData['upwd'],
            'hidden'=>$loginData['hidden'],
        ];

        //短信验证码
        //$this->message();

        $result = Loader::model('Auth')->auth($data);
        if ($result[0] == 0){
            //登录成功
            Cookie::set('uname' , $result['uname'] , 3600);
            Session::set('uid' , $result['uid']);
            Session::set('uname' , $result['uname']);
            Session::set('role' , $result['role']);
            switch ($result['role']){
                case 0:
                    $this->success($result['msg'] , '/stu');
                    break;
                case 1:
                    $this->success($result['msg'] , '/assis');
                    break;
                case 2:
                    $this->success($result['msg'] , '/teach');
                    break;
                case 3:
                    $this->success($result['msg'] , '/admin');
                    break;
                case 4:
                    $this->success($result['msg'] , '/vst');
            }
        }else{
            $this->error($result['msg']);
        }

    }

    public function message($param)
    {
        $accountSid = 'fd586f15056c07be3945feda779aac65';
        $token = '470dd26adeec34fec462941da169b58c';
        $appid = 'aa17367ef87b4056b273f383a9e55aa1';
        $version = '2014-06-30';
        $tmp = '39682';
        date_default_timezone_set('PRC');
        $time = date('YmdHis',time());
        $header = [
            'Accept:application/json',
            'Content-Type:application/json;charset=utf-8',
            'Authorization:'.base64_encode($accountSid.':'.$time),
        ];

        $SigParameter = strtoupper(md5($accountSid . $token . $time));

        $data = [
        'templateSMS'=>[
            'appId'=> $appid,
            'templateId'=>$tmp,
            'to'=>'13230165837',
            'param'=>"$param",
            ],
        ];
        $str = json_encode($data);


        $url = 'https://api.ucpaas.com/'.$version.'/Accounts/'.$accountSid.'/Messages/templateSMS?sig='.$SigParameter;

         $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        
    }

    //退出登录
    public function logout()
    {
        Cookie::delete('uname');
        Session::clear();
    }
}
