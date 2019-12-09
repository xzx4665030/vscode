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
}
