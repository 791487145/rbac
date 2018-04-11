@extends('template.tem_template')
{{--<title>基本设置</title>
</head>
<body>--}}

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        菜单管理
        <span class="c-gray en">&gt;</span>
        基本设置
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>


    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="select-box l">
              <select class="select" onchange="show_sub(this.options[this.options.selectedIndex].value)" size="1" name="demo1" id="select">
                  @foreach($first_menus as $v)
                    <option value="{{$v->id}}" @if($v->id == $first_menu->id) selected @endif>{{$v->name}}</option>
                  @endforeach
              </select>
        </span>
        <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="icon-trash"></i> 批量删除</a>
            <a href="javascript:;" onclick="menu_create('添加菜单','{{url('/manage/system/menu/create')}}','','700')" class="btn btn-primary radius"><i class="icon-plus"></i> 添加菜单</a></span>
        <span class="r">共有数据：<strong>{{$count}}</strong> 条</span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="80">编号</th>
            <th width="100">菜单名</th>
            <th width="40">菜单路由</th>
            <th width="90">所属模块</th>
            <th width="75">排序</th>
            <th width="75">图标</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
            <tr class="text-l" id="tr_{{$menus['id']}}">
                <td><input type="checkbox" value="{{$menus['id']}}" name=""></td>
                <td>{{$menus['id']}}</td>

                <td>{{$menus['name']}}</td>
                <td>{{$menus['route']}}</td>
                <td>{{$menus['name']}}</td>
                <td>{{$menus['sort']}}</td>
                <td>{{$menus['icon']}}</td>
                <td class="f-14 user-manage">
                    <a title="编辑" href="javascript:;" onclick="menu_create('编辑菜单','/manage/system/{{$menus['id']}}/menuedit','','700')" class="ml-5" >
                        <i class="Hui-iconfont Hui-iconfont-edit"></i>
                    </a>
                    <a class="ml-5" onClick="menu_create('添加菜单','/manage/system/{{$menus['id']}}/menuadd','','700')" href="javascript:;" title="添加">
                        <i class="Hui-iconfont Hui-iconfont-add"></i>
                    </a>
                    <a title="删除" href="javascript:;" onclick="menu_del('您确定要删除此菜单吗，删除后子菜单也会删除','1')" class="ml-5">
                        <i class="Hui-iconfont Hui-iconfont-del3"></i>
                    </a>
                </td>
            </tr>
            @if(isset($menus['_child']))
                @foreach($menus['_child'] as $val)
                    <tr class="text-l" id="tr_{{$val['id']}}">
                        <td><input type="checkbox" value="{{$val['id']}}" name=""></td>
                        <td>{{$val['id']}}</td>

                        <td>&nbsp;-&nbsp;|&nbsp;{{$val['name']}}</td>
                        <td>{{$val['route']}}</td>
                        <td>{{$menus['name']}}</td>
                        <td>{{$val['sort']}}</td>
                        <td>{{$val['icon']}}</td>
                        <td class="f-14 user-manage">
                            <a title="编辑" href="javascript:;" onclick="menu_create('编辑菜单','/manage/system/{{$val['id']}}/menuedit','','700')" class="ml-5" >
                                <i class="Hui-iconfont Hui-iconfont-edit"></i>
                            </a>
                            <a class="ml-5" onClick="menu_create('添加菜单','/manage/system/{{$val['id']}}/menuadd','','700')" href="javascript:;" title="添加">
                                <i class="Hui-iconfont Hui-iconfont-add"></i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="menu_del('您确定要删除此菜单吗，删除后子菜单也会删除','/manage/system/menu/delete','{{$val['id']}}')" class="ml-5">
                                <i class="Hui-iconfont Hui-iconfont-del3"></i>
                            </a>
                        </td>
                    </tr>
                        @if(isset($val['_child']))
                            @foreach($val['_child'] as $v)
                                <tr class="text-l" id="tr_{{$v['id']}}">
                                    <td><input type="checkbox" value="{{$v['id']}}" name=""></td>
                                    <td>{{$v['id']}}</td>

                                    <td>&nbsp;-&nbsp;|&nbsp;-&nbsp;|&nbsp;{{$v['name']}}</td>
                                    <td>{{$v['route']}}</td>
                                    <td>{{$val['name']}}</td>
                                    <td>{{$v['sort']}}</td>
                                    <td>{{$v['icon']}}</td>
                                    <td class="f-14 user-manage">
                                        <a title="编辑" href="javascript:;" onclick="menu_create('编辑菜单','/manage/system/{{$v['id']}}/menuedit','','700')" class="ml-5" >
                                            <i class="Hui-iconfont Hui-iconfont-edit"></i>
                                        </a>
                                        <a title="删除" href="javascript:;" onclick="menu_del('您确定要删除此菜单吗','1')" class="ml-5">
                                            <i class="Hui-iconfont Hui-iconfont-del3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                @endforeach
            @endif

        </tbody>
    </table>
    <div id="pageNav" class="pageNav"></div>
    </div>

    <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
@endsection

@section('javascript')
<script type="text/javascript">

    function menu_create(title,url,w,h){
        layer_show(title,url,w,h);
    }

    function show_sub(v)
    {
        location.href = "/manage/system/menu/"+v+'/'+1;
    }

    function menu_del(message,url,id){
        token = $("#token").val();
        layer.confirm(message,function(index){
            $.post(url,{id:id,_token:token},function (data) {
                if(data.code == 1000){
                    $.each(data.data,function(i,e){
                        $("#tr_"+e).remove();
                    })
                    layer.msg(data.message,{icon:1,time:1000})
                }
                if(data.code == 1001){
                    layer.msg(data.message,{icon:1,time:1000})
                }
            })
        });
    }

    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $("#tab-system").Huitab({
            index:0
        });
    });
</script>
@endsection
