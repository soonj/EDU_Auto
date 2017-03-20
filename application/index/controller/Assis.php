<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;

/**
 * Class Assis
 * @package app\index\controller
 * 助教控制器
 */
class Assis extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        parent::verify(get_class());
    }

    public function index($uname)
    {

        //TODO:展示助教用户页
        echo $uname;
    }
}