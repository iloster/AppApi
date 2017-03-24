<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XituModel extends Model
{
    //
    protected $table="xitu_news";
    protected $fillable = ['objectId','title','content','url','username','avatar','updatedAt'];
    public $timestamps = false;

    public function insertHotNews($items){
        foreach($items as $item){
            $flag = $this::where('objectId',$item['objectId'])->get();
            if(count($flag)==0){
                $temp = array();
                $temp['objectId'] = $item['objectId'];
                $temp['title'] = $item['title'];
                $temp['content'] = $item['content'];
                $temp['url'] = $item['url'];
                $temp['username'] = $item['username'];
                $temp['avatar'] = $item['avatar'];
                $temp['updatedAt'] = strtotime($item['updatedAt']);
                $this::insert($temp);
            }
        }
    }
}
