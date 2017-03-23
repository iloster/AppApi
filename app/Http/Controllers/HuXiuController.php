<?php

namespace App\Http\Controllers;

use App\HuxiuModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Log;
use GuzzleHttp\Client;
class HuxiuController extends Controller
{
    //
    const URL = "http://m.api.huxiu.com/portal/%s/%s";
//    http://m.api.huxiu.com/article/44120
    public function findNewsByPage($catId,$page){
        $url = sprintf(self::URL,$catId,$page);
        Log::info('url:'.$url);
        $client = new Client();
        $ret = $client->get($url)->getBody();
//        Log::info('ret:'.$ret);
        $retArr = json_decode($ret,true);
        if(count($retArr['content'])>0){
            $model = new HuxiuModel();
            $model->insertNews($retArr['content']);
        }
        return $ret;
    }


}
