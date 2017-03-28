<?php

namespace App\Http\Controllers;

use App\FollowModel;
use App\HuxiuModel;
use App\NeteaseModel;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;

class MainController extends Controller
{


    public function getLastestNews($userId,$time){
//        第一步 首先获取玩家的关注列表
//        第二步 然后获取最新的新闻
//        第三步 排序，返回
        $follows = $this->getFollowByUserId($userId);
        $ret = array();
        foreach($follows as $follow){
            Log::info('followId:'.$follow['followId']);
            Log::info("time:".$time);
            $ret[] = $this::getNewsByFollowId($follow['followId'],$time);
        }
        return $ret;
    }

    /**
     *
     * @param $userId
     */
//    1.新闻  2.虎嗅  3.知乎  4.果壳  5.豆瓣  6.稀土  7.饭否  8.糗事百科
    public function getFollowByUserId($userId){
        $model = new FollowModel();
        return $model->getFollowByUserId($userId);
    }

    /**
     *
     * @param $follows
     */
    public function getNewsByFollowId($followId,$time){
        $ret = null;
        switch($followId){
            case 1:
                $model = new NeteaseModel();
                $ret = $model->getNewsByTime($time);
                break;
            case 2:
                $model = new HuxiuModel();
                $ret = $model->getNewsByTime($time);
                break;
        }
        return $ret;
    }

}
