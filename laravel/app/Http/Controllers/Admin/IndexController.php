<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(){
        echo "admin的index方法";
    }

    //获取session
    public function session(Request $request){
        //$value = $request->session()->get('key', 'default');
        //dump($value);
        // 指定一个默认值...    
        $value = session('key', 'default');    
        // 在 Session 中存储一条数据...    
        session(['name' => 'jodan']);
        $name = session('name');
        dump($name);

        //删除缓存
        $request->session()->forget('key');
        $key = session('key');
        dump($key);

        //闪存数据
        $request->session()->flash('status', 'Task was successful!');
        $status = session('status');
        dump($status);
    }

    //获取闪存session
    public function sessionFlash(){
        $status = session('status');
        dump($status);
    }


}
