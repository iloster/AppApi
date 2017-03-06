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
//        echo count($matches[0]);
//        dump($matches[0]);
        for($i=1;$i<count($matches);$i++){
            dump($matches[$i]);
//            dump($matches[2]);
        }

    }
}
