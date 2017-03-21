<?php

namespace App\Http\Controllers;

use App\V2exModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Log;
use GuzzleHttp\Client;
class V2exController extends Controller
{
    //
    public function test(){
//        $this->timeTrans("几秒前1");
//        $pattern = '/(\d{0,9}天){0,1}.*?(\d{0,9}小时){0,1}.*?(\d{0,9}分){0,1}/';
//        preg_match($pattern,"2天前",$matchs);
//        dump($matchs);
        
        return time();
    }

    public function getNewsByNode($node,$page){
//        $ret = V2exModel->get($node,$page);
        $model = new V2exModel();
        $rets = $model->getListByNode($node,$page);
        return $rets;
    }

    public function findNewsByNode($node,$page){
//        https://www.v2ex.com/go/qna?p=2
        $url = sprintf("https://www.v2ex.com/go/%s?p=%d",$node,$page);
        Log::info("url=".$url);
        $client = new Client();
        $body = $client->get($url)->getBody();

        Log::info($body);
        $pattern = '/<div class=\"cell from[\s\S]*?<img src=\"(.*?)\"[\s\S]*?<span class=\"item_title\">([\s\S]*?)<\/span>[\s\S]*?<span class=\"small fade\">([\s\S]*?)<\/span>[\s\S]*?<td width=[\s\S]*?>([\s\S]*?)<\/td>/';
        preg_match_all($pattern,$body,$matches);

        $data  = array();
        Log::info("count:".count($matches));
        if(count($matches)>1){
            for($i = 0;$i<count($matches[1]);$i++){
               $item['avatar'] = "http:".$matches[1][$i];
                preg_match('/\/(\d*?)#/',$matches[2][$i],$temp0);
                $item['vid'] = $temp0[1];
                $item['node']= $node;
                $item['title'] = preg_replace("/<(.*?)>/","",$matches[2][$i]);
                $temp = explode("<strong>", $matches[3][$i]);
                if(count($temp)===3){
                    $item['last_reply'] =preg_replace("/<(.*?)>/","",$temp[2]);
                }else{
                    $item['last_reply'] ="" ;
                }
                $temp1 = explode("</strong>", $temp[1]);
                $item['author'] =preg_replace("/<(.*?)>/","",$temp1[0]);
                $public_time = explode("•",str_replace(" ","",str_replace('&nbsp;','',$temp1[1])))[1];
                $item['public_time'] = $this->timeTrans($public_time);
//                dump($item);
                $item['replies'] = str_replace(array(" ","　","\n","\r","\t"),array("","","","",""),preg_replace("/<(.*?)>/","",$matches[4][$i]));
                $data[] = $item;
//                dump($item);
            }
        }
        $this->insertDb($data);
        return $data;
    }

    public function insertDb($arrs){
        foreach($arrs as $arr){
            $ret = V2exModel::where('vid',$arr['vid'])->get();
            Log::info("ret vid:".$arr['vid']."|size=".count($ret));
            if(count($ret) == 0){
                V2exModel::create($arr);
            }
        }
    }


    public function timeTrans($str){
        if($str === "几秒前"){
            return time();
        }else{
            Log::info("str:".$str);
            $pattern = '/(\d{0,9}天){0,1}.*?(\d{0,9}小时){0,1}.*?(\d{0,9}分){0,1}/';
            preg_match($pattern,$str,$matchs);

            if(count($matchs) === 4){
                $day = preg_replace('/([\x80-\xff]*)/i','',$matchs[1]);

                if(strlen($day)===0){
                    $day = 0;
                }else{
                    $day = intval($day);
                }

                $hour = preg_replace('/([\x80-\xff]*)/i','',$matchs[2]);
                if(strlen($hour)===0){
                    $hour = 0;
                }else {
                    $hour = intval($hour);
                }
                $min = preg_replace('/([\x80-\xff]*)/i','',$matchs[3]);
                if(empty($min)){
                    $min = 0;
                }else{
                    $min = intval($min);
                }
            }else{
                $day = 0;
                $hour = 0;
                $min = 0;
            }
        }
//        echo $day.",".$hour.",".$min;
        $timeStr = $day*(-1)." days ".$hour*(-1)." hours ".$min*(-1)." minutes";
//       echo $timeStr."\n";
        return strtotime($timeStr);
    }
}
