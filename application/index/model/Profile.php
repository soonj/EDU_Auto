<?php

namespace app\index\model;

use think\Model;

class Profile extends model
{
	public function user()
	{
		return $this->belongsTo('User');
	}
}