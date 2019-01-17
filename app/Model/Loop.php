<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Loop extends Model
{
    //设置id不可修改
    protected  $guarded = ['id'];
    //链接数据表名
    protected $table = 'loop';
}
