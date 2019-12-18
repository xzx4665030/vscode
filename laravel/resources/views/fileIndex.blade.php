<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Upload File</title>
</head>
<body>
    <!-- 上传文件必须加: enctype="multipart/form-data" -->
    <!-- <form action="{{url('admin/index/saveFile')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="img">
        <button type="submit">提交</button>
    </form> -->

    <form action="{{url('admin/index/putFile')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="img">
        <button type="submit">提交</button>
    </form>
</body>
</html>