<!-- /resources/views/alert.blade.php 组件-->
<!-- <div class="alert alert-danger">   
 {{ $slot }}
</div> -->

<!-- 组件中含插槽 -->
<div class="alert alert-danger">  
  <div class="alert-title">{{ $title }}</div>    
  {{ $slot }}
 </div>