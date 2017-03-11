<?php

namespace app\index\controller;

use think\Controller;


class Blog extends Controller
{
	public function index()
	{
		echo '显示用户列表';
	}

	public function save()
	{
		echo '注册用户';
	}

}