<?php
namespace app\index\model;

use think\Model;
use think\Cookie;
use think\Loader;
use think\Session;

class Zhujiao extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function updatezhujiao($uid, $class ,$fix = 1)
    {
    	//dump($uid);
    	//dump($class);
    	//die;
    	$zhujiaoinfo = Loader::model('zhujiao')->where('class', $class)->select();

    	if ($fix = 0) {
    		//删除助教部分
    		$zid = $zhujiaoinfo[0]['zid'];
    		$update = new Zhujiao;
    		if ($zhujiaoinfo[0]['zhujiao1'] == $uid) {
    			$update->save([
					'zhujiao1' => null,
					],['zid' => $zid]);
    		} elseif($zhujiaoinfo[0]['zhujiao2'] == $uid) {
    			$update->save([
					'zhujiao1' => null,
					],['zid' => $zid]);
    		} elseif($zhujiaoinfo[0]['zhujiao3'] == $uid) {
    			$update->save([
					'zhujiao1' => null,
					],['zid' => $zid]);
    		} else {
    			return false;
    		}
    	} else {
    		//添加助教部分
    		if (empty($zhujiaoinfo)) {
	    		$insert = new Zhujiao;
				$insert->data([
				    'class'  =>  $class,
				    'zhujiao1' =>  $uid,
				]);
				$insert->save();
	    	} else {
	    		$zid = $zhujiaoinfo[0]['zid'];
	    		$update = new Zhujiao;
	    		if (empty($zhujiaoinfo[0]['zhujiao1'])) {
					$update->save([
					    'zhujiao1' =>  $uid,
					],['zid' => $zid]);
	    		} elseif (empty($zhujiaoinfo[0]['zhujiao2'])) {
	    			$update->save([
					    'zhujiao2' =>  $uid,
					],['zid' => $zid]);
					die;
	    		} elseif (empty($zhujiaoinfo[0]['zhujiao3'])) {
	    			$update->save([
					    'zhujiao3' =>  $uid,
					],['zid' => $zid]);
	    		} else {
	    			$msg = '每个班最多只能有三个助教';
	    			dump($msg);
	    			//return false;
	    		}
	    		
	    	}
    	}
    	
    	return true;
    }
}
