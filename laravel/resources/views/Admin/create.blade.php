<!-- <h1>创建文章</h1> -->
@if ($errors->any())  
  <div class="alert alert-danger">     
     <ul>
       @foreach ($errors->all() as $error)                
            <li>{{ $error }}</li>
       @endforeach
      </ul>    
   </div>
 @endif

 <!-- 快速验证 -->
 <form method = 'post' action = "{{url('admin/index/storeForm')}}">
 {{csrf_field()}}
 <!-- form表单需要加token，不然会出现419错误，csrf_token不用自己生成，放进去就行，laravel自己会生成 -->
    <!-- <input type="hidden" name = "_token" value="{{csrf_token()}}"> -->
    <input type="text" name="userName" value="">
    <button type="submit">
        提交
    </button>
 </form>
