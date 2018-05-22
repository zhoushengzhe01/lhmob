@extends('website.layout')

@section('content')
<div class="banner-small" style="background: url({{$group->public}}images/register_banner.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>会员注册</h1>
	</div>
</div>

<div class="register">
	<div class="box">
		<div class="main">
			<a href="javascript:void(0)" class="weblogin action">网站主注册</a>
			<a href="{{$group->url}}/register/ad" class="advertlogin">广告主注册</a>
		</div>
		<div class="content">
			<div class="register_form action">
				<div class="group">
					<label>注册邮箱</label>
					<input name="email" class="input" type="text" placeholder="输入注册邮箱"/> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label>登陆密码</label>
					<input name="password" class="input" type="password" placeholder="输入登录密码"/> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label>确认密码</label>
					<input name="setpassword" class="input" type="password" placeholder="确认登录密码"/> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label>真实姓名</label>
					<input name="nickname" class="input" type="text" placeholder="输入联系人"/> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label>手机号码</label>
					<input name="mobile" class="input" type="text" placeholder="输入手机号码"/> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label>QQ 号码</label>
					<input name="qq" class="input" type="text" placeholder="输入QQ号码"/> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label>专属客服</label>
					<select class="input" name="user_id">
					@foreach ($group->services as $key=>$val)
						<option value="{{$val['id']}}" @if($val['id']==$user_id) selected @endif>领航客服--{{$val['stagename']}}</option>
					@endforeach
					</select> <span class="tishi"><b>*</b></span>
				</div>
				<div class="group">
					<label></label>
					<input type="checkbox" name="agreement" value="1"> 
					我已经认真阅读并同意 <<a target="_blank" href="/protocol"><b>领航联盟服务协议</b></a>>
				</div>
				<div class="group">
					{!! csrf_field() !!}
					<button class="submit" onclick="submit()">注册站长</button>
					<div class="login1">已有账号，<a href="{{$group->url}}/login/web"><b>点击登录</b></a></div>
				</div>

			</div>
		</div>
	</div>
</div>
<script>
	function submit()
	{
		var paramet = {
			email: $("input[name='email']").val(),
			password: $("input[name='password']").val(),
			setpassword: $("input[name='setpassword']").val(),
			nickname: $("input[name='nickname']").val(),
			mobile: $("input[name='mobile']").val(),
			qq: $("input[name='qq']").val(),
			user_id: $("select[name='user_id']").val(),
			agreement: $("input[name='agreement']:checked").val(),
			_token: '{{csrf_token()}}',
		};

		var ajax = $.ajax({
			type: 'POST',
			url: '/webmaster/register.json',
			dataType: "json",
			contentType: 'application/json',
			withCredentials: true,
			data: JSON.stringify(paramet),
			success: function(data)
			{
				message('success', '注册成功，请登陆');

				window.location.href = '/login/web';
			},
			error: function(data) {
				
				var data = JSON.parse(data.responseText);

				message('warning', data.message);
			}
		});
	}
</script>
@endsection