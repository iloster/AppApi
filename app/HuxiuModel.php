<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HuxiuModel extends Model
{
    //
    protected $table="huxiu_news";
    protected $fillable = ['aid','title','summary','author_id','author','img','dateline'];
    public $timestamps = false;

    public function insertNews($items){
        foreach($items as $item){
            $flag = $this::where('aid',$item['aid'])->get();
            if(count($flag)==0){
                $temp = array();
                $temp['aid'] = $item['aid'];
                $temp['title'] = $item['title'];
                $temp['summary'] = $item['summary'];
                $temp['author_id'] = $item['author_id'];
                $temp['img'] = $item['img'];
                $temp['dateline'] = $item['dateline'];
                $this::insert($temp);
            }
        }
    }

    public function getNewsByTime($time){
        return $this::where('dateline','>',$time)->get();
    }
}
