<?php

namespace App\Http\Controllers;

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
        return $ret;
    }
}
