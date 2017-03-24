<?php

namespace App\Http\Controllers;

use App\XituModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;

class XituController extends Controller
{
    //https://gold.xitu.io/api/v1/hot/57c13b2b8ac2470063399ef3/android
    const URL = "https://gold.xitu.io/api/v1/hot/57c13b2b8ac2470063399ef3/android";
    public function findHotNews(){

        $client = new Client();
        $ret = $client->get(self::URL)->getBody();
        $retArr = json_decode($ret,true);
        if(count($retArr['data']['entry'])>0){
            $items = array();
            foreach ($retArr['data']['entry'] as $item) {
                $temp = array();
                $temp['objectId'] = $item['objectId'];
                $temp['title'] = $item['title'];
                $temp['content'] = $item['content'];
                $temp['url'] = $item['url'];
                $temp['username'] = $item['user']['username'];
                $temp['avatar'] = $item['user']['avatar_large'];
                $temp['updatedAt'] = $item['updatedAt'];
                $items[] = $temp;
            }
            $model = new XituModel();
            $model->insertHotNews($items);
        }
        return $ret;
    }
}
