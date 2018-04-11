@extends('template.tem_template_add')
@section('content')

<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
		{!! csrf_field() !!}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->name}}" placeholder="" id="name" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->description}}" placeholder="" id="" name="description">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网站角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@foreach($permissions as $permission)
					<dl class="permission-list">
						<dt>
							<label>
								<input type="checkbox" value="" name="user-Character-0" id="user-Character-0">
								{{$permission['name']}}</label>
						</dt>
						@if(isset($permission['_child']))
							@foreach($permission['_child'] as $value)
								<dd>
									<dl class="cl permission-list2">
										<dt>
											<label class="">
												<input type="checkbox" value="{{$value['id']}}" name="menu[]" id="user-Character-0-0">
												{{$value['name']}}</label>
										</dt>
										@if(isset($value['_child']))
											@foreach($value['_child'] as $val)
												<dd>
													<dl class="cl permission-list2">
														<dt>
															<label class="">
																<input type="checkbox" value="{{$val['id']}}" name="menu_children[]" id="user-Character-0-0">
																{{$val['name']}}
															</label>
															@if(isset($val['_child']))
																@foreach($val['_child'] as $v)
																	<label class="">
																		<input type="checkbox" value="{{$v['id']}}" {{in_array($v['id'],$ids) ? 'checked' : ''}} name="menu_grandchildren[]" id="user-Character-0-0-0">
																		{{$v['name']}}
																	</label>
																@endforeach
															@endif
														</dt>
													</dl>
												</dd>
											@endforeach
										@endif
									</dl>
								</dd>
							@endforeach
						@endif
					</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>
@endsection

@section('javascript')
<script type="text/javascript">
$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
	
	$("#form-admin-role-add").validate({
		rules:{
			name:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit();
			layer.msg('修改成功!',{icon:1,time:1000});
			parent.location.replace(parent.location.href);
		}
	});
});
</script>
@endsection