<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected function initialize()
    {
        parent::initialize();
    }
}