<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    'login'         => 'index/auth/login',
    'reg'           => 'index/auth/reg',
    'signup'        => 'signup/signup',
    'signin'        => 'signin/signin',
    'stu/:uname'    => 'index/stu/index',
    'teach/:uname'  => 'index/teach/index',
    'assis/:uname'  => 'index/assis/index',
    'admin/:uname'  => 'admin/index',
    'vst/:uname/[:func]'    => 'index/vst/index',
];
