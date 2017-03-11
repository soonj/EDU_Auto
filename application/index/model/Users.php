<?php

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Users extends Model
{
	protected $autoWriteTimestamp = true;
	protected $deleteTime = 'delete_time';

	use SoftDelete;

	protected function getStatusAttr($status)
	{
		$statusAry = ['普通用户','管理员','超级管理员'];
		return $statusAry[$status];
	}

	public function profile()
	{
		return $this->hasOne('Profile');
	}
	public function role()
	{
		return $this->belongsToMany('Role');
	}
}