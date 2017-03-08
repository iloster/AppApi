<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Log;
use GuzzleHttp\Client;
class V2exController extends Controller
{
    //
    public function test(){
        return "sss";
    }
    public function getNewsByNode($node,$page){
//        https://www.v2ex.com/go/qna?p=2
        $url = sprintf("https://www.v2ex.com/go/%s?p=%d",$node,$page);
        Log::info("url=".$url);
        $client = new Client();
        $body = $client->get($url)->getBody();

        Log::info($body);
        $pattern = '/<div class=\"cell from[\s\S]*?<span class=\"item_title\">([\s\S]*?)<\/span>[\s\S]*?<span class=\"small fade\">([\s\S]*?)<\/span>/';
        preg_match_all($pattern,$body,$matches);

//        $data  = array();
        Log::info("count:".count($matches));
        if(count($matches)>1){
            for($i = 0;$i<count($matches[1]);$i++){
                $item['title'] = $matches[1][$i];
                $temp = explode("<strong>", $matches[2][$i]);
                if(count($temp)===3){
                    $item['last_reply'] =preg_replace("/<(.*?)>/","",$temp[2]);
                }else{
                    $item['last_reply'] ="" ;
                }
                $temp1 = explode("</strong>", $temp[1]);
                $item['author'] =preg_replace("/<(.*?)>/","",$temp1[0]);
                $item['public_time'] = str_replace('&nbsp;','',$temp1[1]);
                dump($item);
            }
        }
//        for($i=1;$i<count($matches);$i++){
//            dump($matches[$i]);
//            for($j = 0;$j<=9;$j++) {
//                dump(explode("<strong>", $matches[2][$j]));
//            }
//        }

    }
}
