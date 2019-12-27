<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Contracts\Support\JsonableInterface;
use Illuminate\Support\Facades\Redis;

use App\Member;
use App\Card;
use App\Image;

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


    //查询构造器
    public function constructor(){
        $result = DB::table('member')->get();   //返回的是数组对象
        dump($result);

        //从数据表中获取单行或单列
        $result1 = DB::table('member')->first(); //返回是对象
        dump($result1->name);  //读取对象里面的属性

        //分块处理
        DB::table('member')->orderBy('id','desc')->chunk(2,function($memberList){
            foreach($memberList as $mem){
                if(($mem->age) > 15){
                    return false;
                }else{
                    dump($mem);
                }
                
            }
        });

        //selects
        $selects = DB::table('member')->select('name')->get();
        dump($selects);

        //join
        $join = DB::table('member')->join('card','card.memberId','=','member.id')->select('member.*','card.cardNum')->get();
        dump($join);

        //where
        $where = DB::table('member')->where([['name','=','fff'],['age','>','10']])->get();
        dump($where);

        //or
        $or = DB::table('member')->where('age','>','12')->orWhere('name','fff')->get();
        dump($or);

        //when
        $sort = '';
        $when = DB::table('member')->when($sort,function($query) use ($sort){
            return $query->orderBy($sort);
        },function($query){
            return $query->orderBy('id');
        })->get();
        dump($when);

    }

    //分页
    public function page(){
        //分页构造器
        //$users = DB::table('member')->paginate(2);

        //简单分页
        //$users = DB::table('member')->simplePaginate(2);

        //结果转化为JSON
        $users = DB::table('member')->paginate(2);
        return response()->json([
            'status' => true,
            'code'  => 200,
            'message' => 'json数据',
            'data'  => $users,
        ]);
        //return view('page', ['users' => $users]);
    }


    //redis
    public function redis(){
        Redis::set('name', 'Taylor');
        $redisValue = Redis::get('name');
        dump($redisValue);
    }

    //Eloquent
    public function models(Request $request){
        $member = new Member;
        $list = $member->all();
        //dump($list);

        //分块结果
        Member::chunk(2,function($memberList){
            foreach($memberList as $mem){
                //dump($mem);
            }
        });

        //检索单个模型 / 集合
        $sampleResult = $member->find(1);
        $sampleResult = $member->first();
        //dump($sampleResult);

        //检索集合
        $setResultCount = $member->count();
        $setResultMax = $member->max('age');
        $setResultSum = $member->sum('age');
        // dump($setResultCount);
        // dump($setResultMax);
        // dump($setResultSum);

        //插入 配合 Request $request
        // $member->name = $request->name;
        // $member->age = $request->age;
        // $saveResult = $member->save();
        // dump($saveResult);

        //批量赋值 —— 在模型中定义的批量赋值的属性可以插入，之外的不行
        //$createResult = $member->create(['name'=>'杜玉明','age'=>61]);
        //dump($createResult);

        //删除模型
        // $findResult = $member->find(1);
        // $deleteResult = $findResult->delete();
        // dump($deleteResult);

    }

    public function modelInteraction(){
        $member = new Member;
        //一对一
        $hasResult = Member::find(2)->cardNum;
        //dump($hasResult);
        //定义反向关联
        $belongResult = Card::find(2)->member;
        //dump($belongResult);

        //一对多
        $manyResult = $member->find(2)->cardNums;
        dump($manyResult);
    }


    //模型 多态关联
    public function modelMorph(){
        DB::connection()->enableQueryLog();
        //获取member表的图片
        // $result = Member::find(2);
        // $image = $result->images;
        //dump($image);

        //执行 morphTo 调用的方法名来从多态模型中获知父模型

        $result1 = Image::find(2);
        $images = $result1->imageModel;
        $log = DB::getQueryLog();
        dump($log);
        dump($images);
    }



}
