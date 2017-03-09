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
//        $this->timeTrans("几秒前1");
        $pattern = '/(\d{0,9}天){0,1}.*?(\d{0,9}小时){0,1}.*?(\d{0,9}分){0,1}/';
        preg_match($pattern,"2天前",$matchs);
        dump($matchs);
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
                $item['public_time'] =explode("•",str_replace(" ","",str_replace('&nbsp;','',$temp1[1])))[1];
//                dump($item);
                $this->timeTrans($item['public_time']);
            }
        }
    }

    public function timeTrans($str){
        if($str === "几秒前"){
            echo "now";
        }else{
            Log::info("str:".$str);
            $pattern = '/(\d{0,9}天){0,1}.*?(\d{0,9}小时){0,1}.*?(\d{0,9}分){0,1}/';
            preg_match($pattern,$str,$matchs);
            dump($matchs);

        }
    }
}
