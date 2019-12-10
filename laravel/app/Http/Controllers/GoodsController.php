<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#use Illuminate\Support\Facades\Input;
use Input;

class GoodsController extends Controller
{
    //
    public function food(){
        phpinfo();
    }

    public function inputs(){
        echo Input::get('id',0);
        $all = Input::all();
        dump($all);

        $only = Input::only(['name','age']);
        dump($only);

        $has = Input::has('username');
        dump($has);
    }

    //获取浏览器的参数
    public function requests(Request $request,$id){
        $name = $request->input('name');
        dump($name);
        //获取路由参数
        echo $id;
        $ids = $request->route('id');
        dump($ids);
        //获取请求 URL
        $url = $request->fullUrl();
        dump($url);

        //获取所有的输入数据,但是不包含路由参数
        $all = $request->all();
        dump($all);

        //不带参数调用 input 方法，能够获取全部输入值（关联数组形式）
        $input = $request->input();
        dump($input);

        $query = $request->query();
        dump($query);
    }

    

}
