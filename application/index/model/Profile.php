<?php
namespace app\index\model;

use think\Model;

class Profile extends Model
{
    protected $profile;
    protected function initialize()
    {
        parent::initialize();
    }

    public function getProfile($id)
    {
        $this->profile = Profile::get($id);
        return $this->profile;
    }

    public function setProfile($data)
    {
        Profile::update($data);
    }
}