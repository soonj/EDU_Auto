<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Notice extends Model
{
    protected $autoWriteTimestamp = true;
    public function initialize()
    {
        parent::initialize();
    }

    //全站通知，写入noticeList表中，nid为通知id
    public function announce($data)
    {
        //新增notice表
        $notice = new Notice;
        $notice->data($data);
        $notice->save();
        //取出nid
        $nid = $notice->nid;

        //写入noticeList表
        $noticeList = new NoticeList;

        $users = Db::name('user')->select();
        //遍历用户，写入id
        foreach($users as $user){
            $list[] = [
                'uid'=>$user['uid'],
                'nid'=>$nid,
            ];
        }
        $noticeList->saveAll($list , false);
    }

    //获取全站已发布的全站通知
    public function getAnnouncedNotice($uid = null)
    {
        //获取所有已经发布的通知
        if (is_null($uid)){
            $contents = Db::name('notice')->select();
        }else{
            $contents = Db::name('notice')->where('sender_id' , $uid)->select();
        }

        //获取指定用户发布的通知
        if ($contents->isEmpty()){
            return '数据集为空';
        }else{
            $contents->toArray();
            return $contents;
        }
    }

    //获取对我发送的通知内容
    public function getNotices($uid)
    {
        $content = [];
        $user = User::get($uid);
        $nids = $user->notices()->where('status',0)->column('nid');
        foreach ($nids as $nid){
            $content[] = Notice::get($nid);
        }
        return $content;

    }

    public function delNtc()
    {

    }

    public function upNtc()
    {

    }
}