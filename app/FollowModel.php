<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowModel extends Model
{
    //
    protected $table="follower";
    protected $fillable = ['id','userId','followId'];
    public $timestamps = true;

    public function getFollowByUserId($userId){
        return $this::where('userId',$userId)->get();
    }
}
