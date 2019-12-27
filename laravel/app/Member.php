<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //与模型关联的表名
    protected $table = 'member';
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

   /**
     * 可以被批量赋值的属性。
     *
     * var array
     */   
    protected $fillable = ['name','age'];

    //一对一关联
    public function cardNum(){
        return $this->hasOne('App\Card','memberId');
    }

    //一对多
    public function cardNums(){
        return $this->hasMany('App\Card','memberId');
    }

    /**
     * 第二个参数:如果你的前缀是image_ 那么就写image 如果是别的就写别的。
     * 第三个参数:image_type
     * 第四个参数:image_id
     * 第五个参数:关联到那个表的键
     * (以上除了第二个参数都可以省略)
     * 
     */
    public function images(){
        return $this->morphOne('App\Image', 'image','image_type','image_id');  //
    }


}
