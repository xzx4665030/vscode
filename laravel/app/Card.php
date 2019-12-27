<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //与模型关联的表名
    protected $table = 'card';
    /*
    *   制定主键
    */
    public $primaryKey = 'id';

    /*
    *   此模型的连接名称.
    */
    //protected $connection = 'mysql';

    /**
     * 指示模型是否自动维护时间戳
     *
     * 
     */    
    public $timestamps = false;

    //反向关联
    public function member(){
       //因为关联member表的外键不是member_id，将自定义键名作为第二个参数传递给 belongsTo;withDefault方法没找到关联结果返回空对象
       return $this->belongsTo('App\Member','memberId')->withDefault();;
    }

    public function images(){
        return $this->morphOne('App\Image', 'image','image_type','image_id');
    }
}
