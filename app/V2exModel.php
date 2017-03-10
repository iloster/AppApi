<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class V2exModel extends Model
{
    //
    protected $table="v2ex_news";
    public $timestamps = false;
    protected $fillable = ['id','vid','node','title','author','last_reply','public_time'];
}
