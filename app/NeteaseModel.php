<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NeteaseModel extends Model
{
    protected $table="netease_news";
    protected $fillable = ['postid','photoid','title','digest','source','imgsrc','ptime','posttype','imgextra','createtime'];
    public $timestamps = false;
    public function getList(){
//        return DB::table('netease_news')->get();
        return $this->get();
    }

    public function getNewsByTime($time){

    }
}
