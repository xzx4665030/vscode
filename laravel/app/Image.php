<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //与模型关联的表名
    protected $table = 'image';
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

    //获取拥有图片的模型,方法名是image_id的前缀image
    public function imageModel(){
        return $this->morphTo('image','image_type','image_id');
    }


}
