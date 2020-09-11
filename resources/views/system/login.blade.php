<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>后台登录</title>

    <link href="/system/css/font/css/font-awesome.min.css" rel="stylesheet">
    <link href="/system/css/login.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/system/js/jquery.js"></script>
    <script type="text/javascript" src="/system/js/jquery.tscookie.js"></script>
    <script type="text/javascript" src="/system/js/jquery.validation.min.js"></script>
    <script src="/system/js/jquery.supersized.min.js" ></script>
    <script src="/system/js/jquery.progressBar.js" type="text/javascript"></script>

</head>
<body>
<div class="login-layout">

    <div class="top">

        <h5><em></em></h5>
        <h2>平台管理中心</h2>

    </div>

    <form method="post" id="form_login" action="{{url('admin/login')}}">

        <div class="lock-holder">

            <div class="form-group pull-left input-username">

                @csrf

                <label>账号</label>

                <input name="username"   type="text" class="input-text" value="" >

            </div>

            <i class="fa fa-ellipsis-h dot-left"></i> <i class="fa fa-ellipsis-h dot-right"></i>

            <div class="form-group pull-right input-password-box">

                <label>密码</label>

                <input name="password"  class="input-password"  type="password"  value="">

            </div>

        </div>

        <div class="avatar"><img src="/system/images/login/admin.png" alt=""></div>

        <div class="submit"> <span>

<div class="code">
        <div class="code-img"><img src="{{captcha_src()}}" name="codeimage" id="codeimage" border="0"></div>

        <a href="JavaScript:void(0);" id="hide" class="close" title="关闭"><i></i></a><a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='{{captcha_src()}}/' + Math.random();" class="change" title="看不清,点击更换验证码"><i></i></a> </div>

             <input name="captcha" type="text" required="" class="input-code" id="captcha" placeholder="输入验证" pattern="[A-z0-9]{4}" title="验证码为4个字符" autocomplete="off" value="">

      </span> <span>

<input name="" class="input-button" type="submit" value="登录">

      </span>

        </div>

    </form>

</div>

<script>

    $(function(){

        $.supersized({



            // 功能

            slide_interval     : 4000,

            transition         : 1,

            transition_speed   : 1000,

            performance        : 1,



            // 大小和位置

            min_width          : 0,

            min_height         : 0,

            vertical_center    : 1,

            horizontal_center  : 1,

            fit_always         : 0,

            fit_portrait       : 1,

            fit_landscape      : 0,



            // 组件

            slide_links        : 'blank',

            slides             : [

                {image : "/system/images/login/1.jpg"},

                {image : "/system/images/login/2.jpg"},

                {image : "/system/images/login/3.jpg"},

                {image : "/system/images/login/4.jpg"},

                {image : "/system/images/login/5.jpg"}

            ]



        });

        //显示隐藏验证码

        $("#hide").click(function(){

            $(".code").fadeOut("slow");

        });

        $("#captcha").focus(function(){

            $(".code").fadeIn("fast");

        });

        // 回车提交表单

        $('#form_login').keydown(function(event){

            if (event.keyCode == 13) {

                $('.btn-submit').click();

            }

        });

    });

</script>
</body>
</html>