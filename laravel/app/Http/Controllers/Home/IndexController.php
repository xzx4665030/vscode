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
}
