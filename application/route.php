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

//     'stu/index/:uname'       => 'index/stu/index',
//     'shomework/:uname'       => 'index/stu/homework',
//     'teach/index/:uname'     => 'index/teach/bgd_index',
//     'teach/homework/:uname'  => 'index/teach/homework',
//     'teach/fixinfo/:uname'   => 'index/teach/fixinfo',
//     'assis/:uname'           => 'index/assis/index',
//     'admin/:uname'           => 'admin/index',

    'login'                 => 'index/auth/login',
    'reg'                   => 'index/auth/reg',
    'signup'                => 'signup/signup',
    'signin'                => 'signin/signin',
    'stu/:uname/[:func]'    => 'index/stu/index',
    'teach/:uname[:func]'   => 'index/teach/index',
    'assis/:uname[:func]'   => 'index/assis/index',
    'admin/:uname[:func]'   => 'admin/index',
    'vst/:uname/[:func]'    => 'index/vst/index',
];
