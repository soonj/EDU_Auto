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
        $result = Profile::update($data);
        return $result;
    }

    public function updateProfile($data, $field = null, $where = null)
    {
        $result = Profile::where($field, $where)->update($data);
        return $result;
    }
}