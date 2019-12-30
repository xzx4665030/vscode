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

use Mail;

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

    //发送邮件
    public function sendEmail(){
        // ​1:Mail::raw  是发送原生数据,其他的内容发送方式在手册里都有提供;
        // 2.$message->subjuet('');是文件的标题
        // 3.$message->to();发送给谁
        // Mail::raw('你好，我是PHP程序！', function ($message) {
        //     $to = '1310271150@qq.com';
        //     $message ->to($to)->subject('纯文本信息邮件测试');
        // });

        //发送附件 ——  Mail::send();需要传三个参数，第一个为引用的模板，第二个为给模板传递的变量（邮箱发送的文本内容），第三个为一个闭包，参数绑定Mail类的一个实例
        //$image = Storage::get('images/obama.jpg'); //本地文件
        // $name = '大象';
        // $image = 'http://image.baidu.com/search/detail?ct=503316480&z=0&ipn=d&word=%E5%9B%BE%E7%89%87&hs=0&pn=0&spn=0&di=219560&pi=0&rn=1&tn=baiduimagedetail&is=0%2C0&ie=utf-8&oe=utf-8&cl=2&lm=-1&cs=3381573685%2C1866477444&os=1766358314%2C1969526767&simid=4274224315%2C682407512&adpicid=0&lpn=0&ln=30&fr=ala&fm=&sme=&cg=&bdtype=0&oriquery=&objurl=http%3A%2F%2Fdmimg.5054399.com%2Fallimg%2Fpkm%2Fpk%2F22.jpg&fromurl=ippr_z2C%24qAzdH3FAzdH3F14_z%26e3B9nll_z%26e3Bv54AzdH3Ffijgqtkw5kjtAzdH3Fp7rtwgAzdH3Fda888dd9-mbbnb-da_z%26e3Bip4s&gsm=&islist=&querylist=';//网上图片
        // Mail::send('mail.test',['image'=>$image,'name'=>$name],function($message){ 
        //     $to = '1310271150@qq.com';
        //     $message->to($to)->subject('图片测试'); 
        // }); 
        // if(count(Mail::failures()) < 1){
        //     echo '发送邮件成功，请查收！'; 
        // }else{
        //     echo '发送邮件失败，请重试！';
        // } 

        //发送邮件附件
        $name = '我发的第一份邮件'; 
        //$image = storage_path('app/2019_12_18/fe2e2988953e999e5b1a82623a75af1e1069.jpg');
        Mail::send('mail.test',['name'=>$name],function($message){ 
            $to = '1310271150@qq.com';
            $message->to($to)->subject('邮件测试'); 
            $attachment = storage_path('app/agent1128.docx');
            // 在邮件中上传附件 ,防止显示文件名乱码
            $message->attach($attachment,['as'=>"=?UTF-8?B?".base64_encode('代理商首页需求文档1128')."?=.docx"]);
        }); 

        
    }

    public function build(){
        return $this->view('mail.test');
    }


}
