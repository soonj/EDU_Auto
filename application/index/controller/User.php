<?php

namespace app\index\controller;

//当类名冲突时，使用as起别名
use app\index\model\Users as UserModel;
use app\index\model\Profile;
use think\Validate;
use think\Loader;
use think\Session;
use think\Controller;

class User extends Controller
{
	public function yzm()
	{
		return $this->fetch();
	}

	public function checkYzm()
	{
		$data = request()->post();
		/*
		$ret = $this->validate($data,[
		'captcha|验证码'=>'require|captcha'
		]);
		dump($ret);
		*/
		dump(captcha_check($data['captcha']));
	}

	//上传文件界面
	public function icon()
	{
		return $this->fetch();
	}
	//检测文件上传
	public function checkFile()
	{
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file('image');
		// 移动到框架应用根目录/public/uploads/ 目录下
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
		if($info){
			// 成功上传后 获取上传信息
			// 输出 jpg
			echo $info->getExtension();
			// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
			echo $info->getSaveName();
			// 输出 42a79759f284b767dfcb2a0197904287.jpg
			echo $info->getFilename();
		}else{
			// 上传失败获取错误信息
			echo $file->getError();
		}
	}

	public function page()
	{
		$list = UserModel::paginate(1,true);
		$this->assign('list',$list);
		return $this->fetch();
	}

	public function useSession()
	{
		//Session::set('hello','world');
		dump(Session::get('hello'));
	}

	public function reg()
	{
		$data = [
					'name'	=> 	'xiaoming',
					'email'	=> 	'xm@163.com',
					'phone'	=>	'123456',
				];
		//$validate = Loader::validate('User');
		$validate = validate('User');
		/*

		$rule = [
					'name' => 'require|max:25',
					'email' => 'email'
				];

		$validate = new Validate($rule);
		*/
		if ($validate->check($data)) {
			echo '注册成功';
		} else {
			dump($validate->getError());
		}
		
 	}

	public function index()
	{
		/*
		$user = UserModel::get(3);
		dump($users->id);

		
		$pro = Profile::get(1);
		echo $pro->user->nickname;
		
		$user = UserModel::find(4);
		$data = [
					'truename' 	=>  '查查查',
					'qq'		=>	123456,
				];
		$user->profile()->save($data);
		
		$wl = UserModel::get(3);
		echo $wl->profile->truename;

		
		dump(UserModel::withTrashed()->find());
		
		UserModel::destroy(2);
		
		$data = [
					'nickname'	=>	'yyyyy',
					'email'		=>	'yyy@163.com',
					'birthday'	=>	strtotime('1994-03-08')
				];
		UserModel::create($data);
		
		$user = UserModel::get(2);
		$user->nickname = '王美丽';
		$user->save();
		
		$user = UserModel::get(1);
		//$user->nickname = 'mingming';
		//$user->save();
		dump($user->getData('status'));
		
		$user = [
					'nickname'	=>	'王大花',
					'email'		=>	'wdh@163.com',
					'birthday'	=>	strtotime('1983-02-02')
				];
		UserModel::create($user);
		*/
		$user = new UserModel();
		$user->name = 'xiaoming';
		$user->email = 'xiaoming@163.com';	
		//$user->sex = 1;
		$user->save();
		
		echo 111;
	}
}