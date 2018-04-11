<html>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title>登录(Login)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel="stylesheet" href="{{asset('assets/css/reset.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/supersized.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="page-container">
            <h1>登录(Login)</h1>
            {{Form::open(['id'=>'form-member-login'])}}
                <input type="text" name="name" class="username" placeholder="请输入您的用户名！">
                <input type="password" name="password" class="password" placeholder="请输入您的用户密码！">
               {{-- <input type="Captcha" class="Captcha" name="Captcha" placeholder="请输入验证码！">--}}
                <button type="submit" class="submit_button">登录</button>
                <div class="error"><span>+</span></div>
            {{Form::close()}}
            {{--<div class="connect">
                <p>快捷</p>
                <p>
                    <a class="facebook" href=""></a>
                    <a class="twitter" href=""></a>
                </p>
            </div>--}}
        </div>
        @if (!empty(Session::get('message')))
            <input type="hidden" name="name" class="infomation" value="{{Session::get('message')}}">
        @endif
		
        <!-- Javascript -->

        <script src="{{asset('assets/js/jquery-1.8.2.min.js')}}" ></script>
        <script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
        <script type="text/javascript" src="{{asset('static/h-ui/js/H-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('static/h-ui.admin/js/H-ui.admin.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/layer/2.4/layer.js')}}"></script>
        <script src="{{asset('assets/js/supersized.3.2.7.min.js')}}" ></script>
        <script src="{{asset('assets/js/supersized-init.js')}}" ></script>
        <script src="{{asset('assets/js/scripts.js')}}" ></script>
        <script type="text/javascript">
            $(function(){

                if($('input').hasClass('infomation')){
                    var val = $('.infomation').val();
                    layer.msg(val);
                };
                //layer.msg('这是最常用的吧');

                $("#form-member-login").validate({
                    rules:{
                        name:{
                            required:true,
                            minlength:2,
                            maxlength:16
                        },
                        password:{
                            required:true,
                            number:true
                        }
                    },
                    onkeyup:false,
                    focusCleanup:true,
                    success:"valid",
                    submitHandler:function(form){
                        $(form).ajaxSubmit(function (msg) {
                            if(msg.ret == 1000){
                                location.href = '/manage/index'
                            }
                            if(msg.ret == 1001){

                            }
                        });
                    }
                });
            });
        </script>
    </body>
<div style="text-align:center;">
</div>
</html>

