<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('checkLogin');


//定义访问/home的路由
Route::get('/home', function () {
    return '1111';//view('welcome');
});

//定义访问/home1的路由(支持get和post)
Route::any('/home1', function () {
    return '2222';//view('welcome');
});

//定义访问/home2的路由
Route::match(['get','post'],'/home2', function () {
    return '3333';//view('welcome');
});

//必选参数
Route::any('/home3/{id}', function ($id=0) {
    return $id;//view('welcome');
});

//可选参数
Route::any('/home4/{id?}', function ($id=0) {
    return $id;//view('welcome');
});

//路由群组
// Route::prefix('admin')->group(function () {   //Route::group(['prefix'=>'admin'],function(){ 路由 })
//     Route::get('users', function () {
//         // 匹配包含 "/admin/users" 的 URL
//         return "admin/users";
//     });
//     Route::get('users1', function () {
//         // 匹配包含 "/admin/users1" 的 URL
//         return "admin/users1";
//     });
// });


//路由群组
Route::group(['prefix'=>'admin'],function(){ 
    Route::get('users', function () {
        // 匹配包含 "/admin/users" 的 URL
        return "admin/users";
    });
    Route::get('users1', function () {
        // 匹配包含 "/admin/users1" 的 URL
        return "admin/users1";
    });
 });


 //控制器路由写法,这个控制器属于前端加了home
 Route::get('/home/goods/food','GoodsController@food');


 //分目录管理
 Route::get('/admin/goods/food','Admin\IndexController@index');

  //用户输入
  Route::get('/home/goods/inputs','GoodsController@inputs');


  //增添改查路由
  Route::prefix('home/index/')->group(function(){
    Route::get('add','Home\IndexController@add');
    Route::get('update','Home\IndexController@update');
    Route::get('delete','Home\IndexController@delete');
    Route::get('select','Home\IndexController@select');
    //原始sql查询
    Route::get('sql','Home\IndexController@sql');
    //事务
    Route::get('trans','Home\IndexController@trans'); 
    
    //构造器
    Route::get('constructor','Home\IndexController@constructor');

    //分页
    Route::get('page','Home\IndexController@page');
  });

  //中间件组与路有前缀
  Route::group(['prefix'=>'home/index/','middleware'=>['checkLogin']],function(){ 
    Route::get('add','Home\IndexController@add');
    Route::get('update','Home\IndexController@update');
    Route::get('delete','Home\IndexController@delete');
    Route::get('select','Home\IndexController@select');
 });

 //request
 Route::get('home/goods/requests/{id}','GoodsController@requests');


 //response
//  Route::get('/{minutes}', function ($minutes) {
//     return response('Hello World', 200)                  
//           ->header('Content-Type', 'text/plain')
//           ->header('X-Header-One', 'Header Value1')           
//           ->header('X-Header-Two', 'Header Value2')
//           ->cookie('age', '18', $minutes)
//           ->cookie('name', 'xzx', $minutes);
// });


//redirect重定向
// Route::get('/', function () {
//     return redirect('/home/goods/food');
// });


//redirect跳转到控制器 Action
Route::get('/', function () {
    return redirect()->action('Admin\IndexController@index');
});

//redirect跳转到外部域名
// Route::get('/', function () {
//     return redirect()->away('https://www.google.com');
// });


//view
Route::get('/admin/index/views', function () { 
    //return view('admin.greeting', ['name' => 'James']);
    return view('admin.greeting')->with(['name'=>'jodan']);
 });

 //session获取
Route::get('/admin/index/session', 'Admin\IndexController@session');

 //闪存缓存
Route::get('/admin/index/sessionFlash', 'Admin\IndexController@sessionFlash');

//表单验证
Route::get('/admin/index/create', 'Admin\IndexController@create');
Route::post('/admin/index/store', 'Admin\IndexController@store');

Route::post('/admin/index/storeForm', 'Admin\IndexController@storeForm');


//日志
Route::get('/admin/index/log', 'Admin\IndexController@log');
Route::get('/admin/index/Jsonlog', 'Admin\IndexController@Jsonlog');

//模板继承
Route::get('/views/blade', function () {  
    return view('child');
});

//模板组件与插槽
Route::get('/views/useAlert', function () {  
    return view('useAlert');
});

//显示变量
Route::get('/show/{point?}', function ($point = 0) {  
    $data = [
        0=>['name'=>'xzx','age'=>13],
        1=>['name'=>'zhang','age'=>15],
        2=>['name'=>'wang','age'=>3],
    ];
    return view('show', ['name' => 'Samantha','point'=>$point,'data'=>$data]);
});

//检索文件
Route::get('/admin/index/fileExits', 'Admin\IndexController@fileExits');

//文件下载
Route::get('/admin/index/downFile', 'Admin\IndexController@downFile');

//文件上传
Route::get('/admin/index/fileIndex', 'Admin\IndexController@fileIndex');
Route::post('/admin/index/saveFile', 'Admin\IndexController@saveFile');

Route::post('/admin/index/putFile', 'Admin\IndexController@putFile');