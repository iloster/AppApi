<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Log;
use GuzzleHttp\Client;

class NeteaseController extends Controller
{
    const TYPE_ARTICLE = 1;
    const TYPE_PHOTO = 2;

    public function test(){
        return "ssss";
    }
    //
    public function getNewsByType($type,$page)
    {

        $page = intval($page);
        $newsId = Config('constant.'.$type);

        //获取url
        $url = sprintf(Config('constant.list_url'),$newsId,$page*20,($page+1)*20);
        //抓取数据
        $client = new Client();
        Log::info("url=".$url);
        $ret = $client->get($url);
        $body = (array)(json_decode($ret->getBody()));

        //转换成自己需要的格式 title,digest,url,source,postid,imgsrc,ptime,boardid
        $res = array();
        foreach ($body[$newsId] as $value){
            $value = (array)$value;
            if(array_key_exists('postid',$value)) {
                $posttype = $this->checkType($value['postid']);
                Log::info("posttype:" . $posttype);
                if ($posttype == self::TYPE_PHOTO) {
                    $photoid = explode("|", $value['photosetID'])[1];
                    if(array_key_exists('imgextra',$value)){
                        $imgextra = $value['imgextra'];
                    }else{
                        $imgextra = array();
                    }
                } else {
                    $photoid = 0;
                    $imgextra = array();
                }
                $res[] = array(
                    "title" => $value['title'],
                    "digest" => $value['digest'],
                    "postid" => $value['postid'],
//                "url" => $value['url_3w'],
                    "source" => $value['source'],
                    "imgsrc" => $value['imgsrc'],
                    "ptime" => $value['ptime'],
                    "boardid" => $value['boardid'],
                    "photoid" => $photoid,
                    "imgextra" => $imgextra,
                    "posttype" => $posttype,
                );
            }
        }
//        $this->insertData($res);
        return $res;
    }


    public function checkType($postId){
        if(strpos($postId, "PHOT") === 0){
            return self::TYPE_PHOTO;
        }else{
            return self::TYPE_ARTICLE;
        }
    }
}
