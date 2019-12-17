<!-- 保存在  resources/views/layouts/app.blade.php 文件中 -->
<html>   
 <head>      
   <title>App Name - @yield('title')</title>    
 </head>   
 <body>
    @section('sidebar')
     This is the master sidebar.
     <!-- 将show注释后，子模板追加sidebar内容不显示，只显示基模板的内容段 -->
     @show       
     <div class="container">
     @yield('content')       
      </div>   
  </body>
</html>