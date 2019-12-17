<!-- 模板显示变量 -->
{{$name}}

<!-- if语句 -->
@if ($point > 90)
good
@elseif ($point > 80)
jige
@else
no
@endif

<!-- foreach循环 -->
<?php dump($data)?>
@foreach ($data as $value)
    @if ($loop->first)
        This is the first iteration.-- {{$value['name']}} <br/>
    @endif

    {{$value['name']}} -- 当前迭代的索引:{{$loop->index}} -- 当前循环迭代:{{$loop->iteration}} <br/>
@endforeach