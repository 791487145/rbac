@extends('template.tem_template_add')
@section('content')
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-member-add">
        {{ csrf_field() }}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$permission->name}}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>路由：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$permission->display_name}}" placeholder="" id="route" name="display_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$permission->display_order}}" placeholder="" id="sort" name="display_order">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box" style="width:150px;">
                    <select class="select" name="module_type" size="1">
                        @foreach($menus as $menu)
                            <option @if($permission->module_type == $menu['id']) selected @endif value="{{$menu['id']}}">{{$menu['name']}}</option>
                            @if(isset($menu['_child']))
                                @foreach($menu['_child'] as $value)
                                    <option @if($permission->module_type == $value['id']) selected @endif value="{{$value['id']}}">&nbsp;-&nbsp;|&nbsp;{{$value['name']}}</option>
                                    @if(isset($value['_child']))
                                        @foreach($value['_child'] as $val)
                                            <option @if($permission->module_type == $val['id']) selected @endif value="{{$val['id']}}">&nbsp;-&nbsp;|&nbsp;-&nbsp;|&nbsp;{{$val['name']}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
			    </span>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

@endsection
@section('javascript')
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-member-add").validate({
            rules:{
                name:{
                    required:true,
                    minlength:2,
                    maxlength:16
                },
                display_order:{
                    required:true,
                    number:true
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                 $(form).ajaxSubmit(function (msg) {
                     layer.msg(msg.message,{icon:1,time:1000});
                     parent.location.replace(parent.location.href);
                 });

            }
        });
    });
</script>
@endsection