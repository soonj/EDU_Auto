<?php
namespace app\index\model;

use think\Loader;
use think\Model;
use think\Session;
use think\Validate;

class Profile extends Model
{
    protected $profile;
    protected function initialize()
    {
        parent::initialize();
    }

    public function getProfile($id = null)
    {
        if (!is_null($id)){
            $this->profile = Profile::get($id);
        }else{
            $this->profile = Profile::all();
        }
        return $this->profile;
    }

    public function setProfile($data)
    {
        $uid = Session::get('uid');
        $user = User::get($uid);
        $user->profile->save($data);
        return true;
    }
}