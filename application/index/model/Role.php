<?php
namespace app\index\model;

use think\Model;

//角色查询，返回权限
class Role extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    //查询用户权限
    public function getRole($id)
    {
        //获取多个用户权限
        if (is_array($id)){
            $list = User::all($id);
            return $list;
        }

        //获取单个用户权限
        $user = User::get($id);
        return $user->role->role;
    }

    //
    public function setRole($id)
    {

    }

}