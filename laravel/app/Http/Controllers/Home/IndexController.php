<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IndexController extends Controller
{
    //
    public function index(){
        echo "home的index方法";
    }

    public function add(){
        $data = [
            0=>['name'=>'大桥','age'=>18],
            1=>['name'=>'大桥1','age'=>19],
        ];
        $result = DB::table('member')->insert($data);
        dump($result);
    }

    public function select(){
        $result = DB::table('member')->get();
        dump($result);

        $result1 = DB::table('member')->select('name')->get();
        dump($result1);
    }


    //原始sql查询
    public function sql(){
        //select
        $selectRequst = DB::select("select * from member");  //返回的是数组对象
        //dump($selectRequst);
        $selectRequst1 = DB::select("select * from member where id = ?",[1]);  //? 表示参数绑定
        //dump($selectRequst1);

        //insert
        //DB::insert("insert into member (name,age) values (?,?)",['zhang',14]);

        //update
        DB::update("update member set name = 'xiaoqiao' where id = ?",[1]);

        //delete
        //DB::delete("delete from member where id = ?",[5]);

    }


    //原始事务
    public function trans(){
        DB::transaction(function () {  
            DB::table('member')->where('id',1)->update(['name' => 'fff']);    
            DB::table('member')->where('id',4)->delete();
        });
    }
}
