<!-- 构建alert组件 -->
<!-- @component('alert') 
<strong>Whoops!</strong> Something went wrong!
@endcomponent -->

<!-- 构建组件以及自定义插槽内容  报错-->
@component('alert', ['foo' => 'bar'])
    @slot('title')
        Forbidden
    @endslot
You are not allowed to access this resource!@endcomponent