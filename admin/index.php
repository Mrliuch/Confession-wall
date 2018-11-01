<?php
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] > 0) {
        # 如果存在登录记录则进入后台。注意：因为Cookie被微信禁用，导致$_SESSION，所以用微信登录是无法打开后台的。
        
    }else {
        # 使用脚本重定向回到登录界面
        $url="login.php";
        echo "<script language=\"javascript\">";
        echo "location.href=\"$url\"";
        echo "</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>表白墙后台管理</title>
    <link rel="stylesheet" href="layui/css/layui.css">
    <style>
        body, html, .layui-table-view{
            margin:0;
            padding:0;
        }
    </style>
</head>
<body>
    <table class="layui-table" lay-data="{height:'full-0', url:'admin.php', page:true, id:'test', even: true}" lay-filter="test">
    <thead>
        <tr>
        <th lay-data="{field:'id', width:80, sort: true}">ID</th>
        <th lay-data="{field:'nickName', width:120, sort: true, event: 'setNickName'}">昵称</th>
        <th lay-data="{field:'tureName', width:120, sort: true, event: 'setTureName'}">真实名字</th>
        <th lay-data="{field:'gender', width:80, sort: true, event: 'setGender'}">性别</th>
        <th lay-data="{field:'toWho', width:120, sort: true, event: 'setToWho'}">表白对象</th>
        <th lay-data="{field:'itsGender', width:120, sort: true, event: 'setItsGender'}">对象性别</th>
        <th lay-data="{field:'contents', width:350, sort: true, event: 'setContents'}">内容</th>
        <th lay-data="{field:'love', width:80, sort: true, event: 'setLove'}">点赞</th>
        <th lay-data="{field:'email', width:80, sort: true, event: 'setEmail'}">邮箱</th>
        <th lay-data="{field:'isSended', width:100, sort: true}">发送状态</th>
        <th lay-data="{field:'isDisplay', width:70, sort: true}">隐藏</th>
        <th lay-data="{field:'ip', width:100, sort: true}">ip</th>
        <th lay-data="{field:'mtime', width:180, sort: true}">修改时间</th>
        <th lay-data="{fixed: 'right', width:320, align:'center', toolbar: '#barDemo'}"></th>
        </tr>
    </thead>
    </table>
    <script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="getComment">查看评论</a>
    <a class="layui-btn layui-btn-mini" lay-event="getGuessHistory">查看猜名字历史</a>
    <a class="layui-btn layui-btn-mini" lay-event="resendEmail">重发邮件</a>
    <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
    </script>
    <script src="layui/layui.all.js"></script>
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script>
        layui.use('table', function(){
            var table = layui.table;

            //监听单元格事件和工具条
            table.on('tool(test)', function(obj){
                var data = obj.data;
                if(obj.event === 'setLove'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的点赞数'
                        ,value: data.love
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editLikes", id:data.id, targetNum:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        love: value
                        });
                    });
                }else if(obj.event === 'setEmail'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的邮箱'
                        ,value: data.email
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editEmail", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        email: value
                        });
                    });
                }else if(obj.event === 'setContents'){
                    layer.prompt({
                        formType: 2
                        ,title: '修改 ID 为 ['+ data.id +'] 的表白内容'
                        ,value: data.contents
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editContent", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        contents: value
                        });
                    });
                }else if(obj.event === 'setNickName'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的昵称'
                        ,value: data.nickName
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editNickName", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        nickName: value
                        });
                    });
                }else if(obj.event === 'setTureName'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的真实名字'
                        ,value: data.tureName
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editTureName", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        tureName: value
                        });
                    });
                }else if(obj.event === 'setGender'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的性别'
                        ,value: data.gender
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editGender", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        gender: value
                        });
                    });
                }else if(obj.event === 'setToWho'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的表白对象'
                        ,value: data.toWho
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editToWho", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        toWho: value
                        });
                    });
                }else if(obj.event === 'setItsGender'){
                    layer.prompt({
                        formType: 0
                        ,title: '修改 ID 为 ['+ data.id +'] 的表白对象的性别'
                        ,value: data.itsGender
                    }, function(value, index){
                        layer.close(index);
                        
                        //这里一般是发送修改的Ajax请求
                        $.ajax({
                            type: "post",
                            url: "admin.php",
                            data: {act:"editItsGender", id:data.id, target:value},
                            dataType: "html",
                            success: function (response) {
                                if (response == 1){
                                    layer.msg("修改成功！");
                                }else{
                                    layer.msg("修改失败！");
                                }
                            }
                        });
                        //同步更新表格和缓存对应的值
                        obj.update({
                        itsGender: value
                        });
                    });
                }else if(obj.event === 'getComment'){
                // layer.msg('ID：'+ data.id + ' 的查看操作');
                $.ajax({
                    type: "post",
                    url: "admin.php",
                    data: {act:"getComment", id:data.id},
                    dataType: "html",
                    success: function (response) {
                        
                    }
                });
                    
                } else if(obj.event === 'del'){
                layer.confirm('真的删除该条表白么', function(index){
                    $.ajax({
                        type: "post",
                        url: "admin.php",
                        data: {act:"deletePosts", id:data.id},
                        dataType: "html",
                        success: function (response) {
                            if (response == 1) {
                                layer.msg("删除成功！");
                            }else{
                                layer.msg("删除失败！");
                            }
                            
                        }
                    });
                    obj.del();
                    layer.close(index);
                });
                } else if(obj.event === 'getGuessHistory'){
                // layer.alert('编辑行：<br>'+ JSON.stringify(data))

                } else if(obj.event === 'resendEmail'){
                // layer.alert('编辑行：<br>'+ JSON.stringify(data))
                    $.ajax({
                        type: "post",
                        url: "admin.php",
                        data: {act:"resendEmail", id:data.id, email:data.email},
                        dataType: "html",
                        success: function (response) {
                            layer.msg(response);
                        }
                    });
                }
            });
        });
    </script>
    
</body>
</html>