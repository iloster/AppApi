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
            $followId = $follow['followId'];
            $items = $this::getNewsByFollowId($follow['followId'],$time);
            foreach($items as $item){
                $ret[] = $items;
            }
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
                $result = $model->getNewsByTime($time);
                foreach($result as $item) {
                    $temp = array();
                    $temp['title'] = $item['title'];
                    $temp['content'] = $item['digest'];
                    $temp['time'] = $item['ptime'];
                    $imgextra = json_decode($item['imgextra'], true);
                    if (count($imgextra) == 0) {
                        $temp['imgextra'][] = $item['imgsrc'];
                    } else {
                        $temp['imgextra'] = $imgextra;
                    }
                    $ret[] = $temp;
                }
                break;
            case 2:
                $model = new HuxiuModel();
                $result = $model->getNewsByTime($time);
                foreach($result as $item){
                    $temp = array();
                    $temp['title'] = $item['title'];
                    $temp['content'] = $item['summary'];
                    $temp['time'] = $item['dateline'];
                    $temp['imgextra'][] = $item['img'];
                    $ret[] = $temp;
                }

                break;
        }
        return $ret;
    }

}
