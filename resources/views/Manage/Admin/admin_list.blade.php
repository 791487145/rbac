@extends('template.tem_template')

@section('content')
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">
		<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
			<a href="javascript:;" onclick="admin_add('添加管理员','create','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
		</span>
		<span class="r">共有数据：<strong>54</strong> 条</span>
	</div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">员工列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="150">登录名</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>
				<th>角色</th>
				<th width="130">加入时间</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr class="text-c">
					<td><input type="checkbox" value="{{$user->id}}" name=""></td>
					<td>{{$user->id}}</td>
					<td>{{$user->name}}</td>
					<td>{{$user->telephone}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->role_name}}</td>
					<td>{{$user->created_at}}</td>
					@if($user->status == 1)
						<td class="td-status"><span class="label label-success radius">已启用</span></td>
					@endif
					@if($user->status == 2)
						<td class="td-status"><span class="label label-default radius">已禁用</span></td>
					@endif

					<td class="td-manage">
						@if($user->status == 1)
							<a style="text-decoration:none" onClick="admin_stop(this,'{{$user->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
						@endif
						@if($user->status == 2)
							<a onClick="admin_start(this,'{{$user->id}}')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
						@endif
						<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','{{url('/manage/admin/'.$user->id.'/systemUserEdit')}}','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a title="删除" href="javascript:;" onclick="admin_del(this,'{{$user->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
					</td>

					{{--@if($user->status == 2)
						<td class="td-status"><span class="label label-default radius">已禁用</span></td>
						<td class="td-manage">
							<a onClick="admin_start(this,'{{$user->id}}')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
							<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','admin-add.html','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							<a title="删除" href="javascript:;" onclick="admin_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
						</td>
					@endif--}}
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
@endsection


@section('javascript')
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		var _token = $("#_token").val();
		$.ajax({
			type: 'DELETE',
			url: 'delete',
			data: {_token:_token,id:id},
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		var _token = $("#_token").val();
		$.ajax({
			url: 'operation',
			type: 'PUT',
			data: {_token:_token,id:id,status:2},
			success: function( response ) {
			}
		});
		
		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
		$(obj).remove();
		layer.msg('已停用!',{icon: 5,time:1000});
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		var _token = $("#_token").val();
		$.ajax({
			url: 'operation',
			type: 'PUT',
			data: {_token:_token,id:id,status:1},
			success: function( response ) {
			}
		});

		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
		$(obj).remove();
		layer.msg('已启用!', {icon: 6,time:1000});
	});
}
</script>
@endsection