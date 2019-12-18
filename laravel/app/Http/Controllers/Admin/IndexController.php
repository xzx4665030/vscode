<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use Log;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


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

    //检索文件
    public function fileExits(){
        $path = storage_path();  //文件路径 D:\git\vscode\laravel\storage
        dump($path);
        //写入磁盘
        $file = file_get_contents("D:\phpstudy\PHPTutorial\WWW\jtap\public\weixin.png");  //将图片内容读取出来
        $result = Storage::put('public/file.jpg', $file);
        //dump($result);   //true ，如果不加file_get_contents这个函数，存储结果也是true但是图片受损

        //检索文件
        $isExits = Storage::exists('public/file.jpg');
        dump($isExits);   //true;文件不存在既是false

        //删除文件
        //$delete = Storage::delete('public/file.jpg');
        //dump($delete);  //true
        
    }

    //文件下载
    public function downFile(){
        $files = storage_path('app/public/file.jpg'); 
        $name = basename($files);  //返回file.jpg
        
        return response()->download($files, $name,$headers = ['Content-Type'=>'application/zip;charset=utf-8']);   //如果文件不存在会报错，如：The file "public/file.jpg" does not exist
    }

    //文件上传
    public function fileIndex(){
        return view('fileIndex');
    }

    public function saveFile(Request $request){  //保存
        // $files = $_FILES;
        // dump($files);
        $file = $request->file('img');
        // 此时 $this->upload如果成功就返回文件名不成功返回false
        $fileName = $this->upload($file);
        if ($fileName){
            return $fileName;
        }
        return '上传失败';
    }

    /**
     * 验证文件是否合法
     */
    public function upload($file, $disk='public') {
        // 1.是否上传成功
        if (! $file->isValid()) {
           return false;
        }

        // 2.是否符合文件类型 getClientOriginalExtension 获得文件后缀名
        $fileExtension = $file->getClientOriginalExtension();
        if(! in_array($fileExtension, ['png', 'jpg', 'gif'])) {
            return false;
        }

        // 3.判断大小是否符合 2M
        $tmpFile = $file->getRealPath(); //获取临时绝对路径
        if (filesize($tmpFile) >= 2048000) {
            return false;
        }

        // 4.是否是通过http请求表单提交的文件
        if (! is_uploaded_file($tmpFile)) {
            return false;
        }

        // 5.每天一个文件夹,分开存储, 生成一个随机文件名，强烈建议在处理大文件时使用此方法。
        $fileName = date('Y_m_d').'/'.md5(time()) .mt_rand(0,9999).'.'. $fileExtension;
        if (Storage::disk($disk)->put($fileName, file_get_contents($tmpFile)) ){
            // /storage/2019_12_18/3ba455bb3373577b324c20f596d552818274.jpg  返回少了app/public;
            //解决方法：框架自带的一个命令是 php artisan storage:link，但是这个命令映射的是 storage 下的 public 目录
            return Storage::url($fileName);   
        }
    }


    //自动流式传输
    public function putFile(Request $request){
        $fileName = date('Y_m_d');  //文件夹
        $file = $request->file('img');
        $fileExtension = $file->getClientOriginalExtension();
        $newFile = md5(time()) .mt_rand(0,9999).'.'. $fileExtension;  //自定义文件名
        // 自动为文件名生成唯一的ID...
        // $result = Storage::disk('public')->putFile($fileName, $request->file('img'));
        // dump($result);
        //手动指定文件名...
        $result = Storage::putFileAs($fileName, $file,$newFile);
        dump($result);

    }


}
