@extends('website.layout')

@section('content')
<div class="banner-small" style="background: url({{$group->public}}images/login_banner.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>会员登陆</h1>
	</div>
</div>

<div class="login">
	<div class="box">
	<div class="main">
			<a href="{{$group->url}}/login/web" class="weblogin action" >网站主登陆</a>
			<a href="{{$group->url}}/login/ad" class="advertlogin">广告主登陆</a>
		</div>

		<div class="content">
			<div class="login_form action">
				<div class="group">
					<label>用户名</label>
					<input name="username" class="input" type="text" placeholder="请输入用户名" />
				</div>
				<div class="group">
					<label>密码</label>
					<input name="password" class="input" type="password" placeholder="请输入密码" />
				</div>
				<div class="group">
					{!! csrf_field() !!}
					<button class="submit" onclick="submit()">立即登录</button>
				</div>
				<div class="group">
					<a href="javascript:void(0)" onclick="message('success', '忘记密码，请联系你的客服')" class="forget">忘记密码？</a>
					<a href="{{$group->url}}/register/web" class="register1">点此注册</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function submit()
	{
		var paramet = {
			username: $("input[name='username']").val(),
			password: $("input[name='password']").val(),
			_token: '{{csrf_token()}}',
		};

		var ajax = $.ajax({
			type: 'POST',
			url: '/webmaster/login.json',
			dataType: "json",
			contentType: 'application/json',
			withCredentials: true,
			data: JSON.stringify(paramet),
			success: function(data)
			{
				message('success', '登陆成功');

				window.location.href = '/webmaster';	
			},
			error: function(data) {
				
				var data = JSON.parse(data.responseText);

				message('warning', data.message);
			}
		});
	}
</script>
@endsection