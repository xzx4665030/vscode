<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{

    //验证规则可自己添加需要验证的字段
    protected $rules = [    
        'userName' => 'required|between:2,4',
        'userAge' => 'required|integer',
        'userSex' => 'required|integer',
        'addr' => 'required',
    ];
    //这里我只写了部分字段，可以定义全部字段
    protected $strings_key = [
        'userName' => '用户名',
        'userAge' => '年龄',
        'userSex' => '性别',
        'addr' => '地址',
    ];
    //这里我只写了部分情况，可以按需定义
    protected $strings_val = [
        'required'=> '为必填项',
        'min'=> '最小为:min',
        'max'=> '最大为:max',
        'between'=> '长度在:min和:max之间',
        'integer'=> '必须为整数',
        'sometimes'=> '',
    ];

    //返回给前台的错误信息
    public function messages(){
        $rules = $this->rules();
        $k_array = $this->strings_key;
        $v_array = $this->strings_val;
        foreach ($rules as $key => $value) {
            $new_arr = explode('|', $value);//分割成数组
            foreach ($new_arr as $k => $v) {
                $head = strstr($v,':',true);//截取:之前的字符串
                if ($head) {$v = $head;}
                $array[$key.'.'.$v] = $k_array[$key].$v_array[$v];                  
            }
        }
        return $array;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 如果 authorize 方法返回 false，则会自动返回一个包含 403 状态码的 HTTP 响应，也不会运行控制器的方法。
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // return [
        //     //
        //     'title' => 'required|unique:posts|max:255',        
        //     'body' => 'required', 
        // ];

        $rules = $this->rules;
        return $rules;
    }
}
