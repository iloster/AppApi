<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XituModel extends Model
{
    //
    protected $table="xitu_news";
    protected $fillable = ['objectId','title','content','url','username','avatar','updatedAt'];
    public $timestamps = false;
}
