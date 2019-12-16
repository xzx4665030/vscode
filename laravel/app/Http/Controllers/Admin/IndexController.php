<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use Log;


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

    //显示并创建表单
    public function create(){
        return view('admin/create');
    }

    //保存表单
    public function store(Request $request){
        $validatedData = $request->validate([      
            'title' => 'bail|required|unique:posts|max:255',      //某个属性第一次验证失败后停止运行验证规则，你需要附加 bail 规则到该属性  
            'body' => 'required',    
        ]);
    }

    //保存表单——表单请求
    public function storeForm(StorePost $request){
        $validated = $request->validated();
    }

    //日志
    public function log(){
        $message = 'Some message';
        $log = ['user_id'=>1,'user_name'=>'abcd']; 
        Log::channel('myapplog')->info($message, $log);  //Log后的数组会自动转成Json存到日志记录中

        Log::info($log);
    }

    //自定义json格式日志
    public function Jsonlog(){
        $message = 'Some message';
        $log = ['user_id'=>1,'user_name'=>'abcd']; 
        Log::channel('myapplog')->info($message, $log);  //Log后的数组会自动转成Json存
    }


}
