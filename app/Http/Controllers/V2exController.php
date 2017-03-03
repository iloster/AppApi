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
//        $client = new Client();
//        $body = $client->get($url)->getBody();

        $str = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
            <tr>
                <td width=\"48\" valign=\"top\" align=\"center\"><a href=\"/member/rockivy\"><img src=\"//v2ex.assets.uxengine.net/avatar/ef29/35fa/85092_normal.png?m=1420435896\" class=\"avatar\" border=\"0\" align=\"default\" /></a></td>
                <td width=\"10\"></td>
                <td width=\"auto\" valign=\"middle\"><span class=\"item_title\"><a href=\"/t/344547#reply38\">有用过 [招行闪电贷] 的同学吗？可以这样贷出来去买理财薅羊毛吗？</a></span>
                <div class=\"sep5\"></div>
                <span class=\"small fade\"><strong><a href=\"/member/rockivy\">rockivy</a></strong> &nbsp;•&nbsp; 45 分钟前 &nbsp;•&nbsp; 最后回复来自 <strong><a href=\"/member/iamzhuyi\">iamzhuyi</a></strong></span>
                </td>
                <td width=\"50\" align=\"right\" valign=\"middle\">

                    <a href=\"/t/344547#reply38\" class=\"count_livid\">38</a>

                </td>
            </tr>
        </table>";
        $pattern = "/<table cellpadding.*>[\s\S]*<img.*?src=\"(.*?)\"[\s\S]*<a[\s\S]*>([\s\S]*)<\/a>[\s\S]*<\/table>/";
        preg_match_all($pattern,$str,$matches);
        foreach ($matches as $match){
//            Log::info("match:".$match[0]);
            dump($match[0]);
        }
    }
}
