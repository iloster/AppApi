<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class V2exModel extends Model
{
    //
    protected $table="v2ex_news";
    public $timestamps = false;
    protected $fillable = ['id','vid','node','title','author','avatar','last_reply',"replies",'public_time'];

    function getListByNode($node,$page){
        return $this::where("node",$node)->orderBy('id','desc')->take(10)->get();
    }
}
