@extends('layout')

@section('content')
<div class="banner banner2" style="background: url(/images/img1920_4.jpg) no-repeat; background-size: 100% 100%">
	<div class="banner-img">
		<div class="title">会员登陆</div>
	</div>
</div>

<div class="login">
	<div class="box">
		<div class="main">
			<a href="/webmaster/login" class="weblogin">网站主登陆</a>
			<a href="/advertiser/login" class="advertlogin action">广告主登陆</a>
		</div>
		<div class="content">
			<div class="login_form action">
				<form action="" method="post">
				<div class="group">
					<label>用户名</label>
					<input name="username" class="input" value="" type="text" placeholder="请输入用户名" />
				</div>
				<div class="group">
					<label>密码</label>
					<input name="password" class="input" value="" type="password" placeholder="请输入密码" />
				</div>
				<div class="group">
					{!! csrf_field() !!}
					<input class="submit" type="submit" value="立即登录"/>
				</div>
				<div class="group">
					<a href="javascript:void(0)" onclick="alert('忘记密码请联系你的客服')" class="forget">忘记密码？</a>
					<a href="/register" class="register1">点击登陆</a>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection