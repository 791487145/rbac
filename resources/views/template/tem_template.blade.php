<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />

    <script type="text/javascript" src="{{asset('lib/html5shiv.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/respond.min.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('static/h-ui/css/H-ui.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/h-ui.admin/css/H-ui.admin.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('lib/Hui-iconfont/1.0.8/iconfont.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/h-ui.admin/skin/default/skin.css')}}" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{asset('static/h-ui.admin/css/style.css')}}" />

    <script type="text/javascript" src="{{asset('lib/DD_belatedPNG_0.0.8a-min.js')}}" ></script>
    <script>DD_belatedPNG.fix('*');</script>

</head>
<body>
@if(isset($menu_data))
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> {{$menu_data['menu_data'][0]['name']}}
       <span class="c-gray en">&gt;</span> {{$menu_data['menu_data'][0]['_child'][0]['name']}}
       <span class="c-gray en">&gt;</span> {{$menu_data['menu_data'][0]['_child'][0]['_child'][0]['name']}}
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
@endif
@if (!empty(Session::get('message')))
    <input type="hidden" name="name" class="infomation" value="{{Session::get('message')}}">
@endif
@yield('content')



<script type="text/javascript" src="{{asset('lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('static/h-ui/js/H-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('static/h-ui.admin/js/H-ui.admin.js')}}"></script>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
@yield("javascript")
<script type="text/javascript">
    $(function(){

        if($('input').hasClass('infomation')){
            var val = $('.infomation').val();
            layer.msg(val);
            setTimeout(function () { a() }, 5000);
        }

        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $("#tab-system").Huitab({
            index:0
        });

        function a(){
            layer_close();
        }
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
