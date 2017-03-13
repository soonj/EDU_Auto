<?php
namespace app\index\model;

use app\index\model\User;
use app\index\validate\UserValidate;
use think\Loader;
use think\Model;

class Auth extends Model
{

    public function auth(array $data)
    {
        $validate = Loader::validate('User');
        if(!$validate->check($data)) {
            dump($validate->getError());
            return '不满足规则';
        }

        $uname = [
                    'uname' => $data['uname'],
                ];

        $user = User::get($uname);

        if ($data['hidden'] == 1) {
            //登录验证
            if ($user) {
                //验证密码一致
                if ($user['upwd'] == $data['upwd']) {
                    echo 'chenggong';
                } else {
                    echo 'shibai';
                }
            } else {
                echo 'meiyou';
            }

        }elseif($data['hidden'] == 0) {
            //注册验证
            if ($user) {
                echo 'yicunzai';
            }else{
                $user = new User($data);
                $user->allowField(true)->save();
                echo $user->uid;
            }
        }
    }
}