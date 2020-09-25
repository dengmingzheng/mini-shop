<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('system/css/base.css')}}"/>
    <script src="{{asset('system/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('system/layer/layer.js')}}"></script>
    <script src="{{asset('system/js/admincp.js')}}"></script>
    @yield('style')
</head>
<body>

<!--头部开始-->
<div class="layout">
    <div class="layout-header"> <!-- Title/Logo - can use text instead of image -->
        <div id="title"><a href="{{url('admin/index')}}"></a></div>
        <!-- Top navigation -->
        <div class="top-nav">
            <ul>
                <li class="adminid" title="您好:{{auth()->guard('admin')->user()->username}}">您好&nbsp;:&nbsp;<strong>{{auth()->guard('admin')->user()->username}}</strong></li>
                <li><a href="{{url('/resetPassword')}}"><span>修改密码</span></a></li>
                <li><a href="{{url('admin/logout')}}" title="安全退出"><span>安全退出</span></a></li>
                <li><a href="{{url('/')}}" title="商城首页" target="_blank"><span>商城首页</span></a></li>
            </ul>
        </div>
        <!-- End of Top navigation -->
        <!-- Main navigation -->
        <nav id="nav" class="main-nav">
            <ul>
                {{--顶部导航--}}
                @foreach($topNav as $nav)
                    <li><a class="link @if(!empty($nav['class'])){{$nav['class']}} @endif"  href="{{url($nav['url'])}}"><span>{{$nav['title']}}</span></a></li>
                @endforeach
            </ul>
        </nav>
        <div class="loca"><strong>您的位置:</strong>
            <div id="crumbs" class="crumbs"><span>{{$topTitle}}</span><span class="arrow">&nbsp;</span><span>{{$navTitle}}</span></div>
        </div>

    </div>
    <div></div>
</div>
<!--头部结束-->
<div style="clear: both"></div>

<div class="container">
    <!--左边侧边栏开始-->
    <div class="menutd">
        <div id="mainMenu" class="main-menu">

            <ul  style="display: block;">
                <li>
                    <dl>
                        <dd>
                            <ol>
                                @foreach($leftNav as $item)
                                    <li nc_type=""><a href="{{url($item['url'])}}" class="@if(!empty($item['class'])){{$item['class']}} @endif">{{$item['title']}}</a></li>
                                @endforeach
                            </ol>
                        </dd>
                    </dl>
                </li>
            </ul>

        </div>
    </div>

    <!--左边侧边栏结束-->

    <!--主体内容开始-->

    <div class="content">
        @yield('content')
    </div>
</div>
<script>
    $(function(){

        var h=$('.content').outerHeight(true);

        if(h < 850){
            h=850
        }

       $('.menutd').height(h);

       // $('.content').width($(document).width()-$('.menutd').width()-20);

    });
</script>
@yield('script')
</body>
</html>