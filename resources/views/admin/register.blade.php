@extends('layout')

@section('content')

<div class="banner banner2" style="background: url(/images/img1920_4.jpg) no-repeat; background-size: 100% 100%">
	<div class="banner-img">
		<div class="title">会员注册</div>
	</div>
</div>

<div class="register">
	<div class="box">
		<div class="main">
			<a href="/webmaster/register" class="weblogin action">网站主注册</a>
			<a href="/advertiser/register" class="advertlogin">广告主注册</a>
		</div>
		<div class="content">
			<div class="register_form action" id="weblogin">
				<form action="" method="post">
					<div class="group">
						<label>邮箱</label>
						<input name="email" class="input" type="text" placeholder="输入注册邮箱" /> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label>密码</label>
						<input name="password" class="input" type="password" placeholder="输入登录密码" /> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label>确认密码</label>
						<input name="setpassword" class="input" type="password" placeholder="确认登录密码" /> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label>真实姓名</label>
						<input name="nickname" class="input" type="text" placeholder="输入真实姓名" /> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label>手机号码</label>
						<input name="mobile" class="input" type="text" placeholder="输入手机号码" /> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label>QQ 号码</label>
						<input name="qq" class="input" type="text" placeholder="输入QQ号码" /> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label>选择客服</label>
						<select name="service_id" class="input">
						@foreach ($services as $k=>$v)
						<option value="{{$v['id']}}">领航客服--{{$v['stagename']}}</option>
						@endforeach
						</select> <span class="tishi"><b>*</b></span>
					</div>
					<div class="group">
						<label></label>
						<input type="checkbox" name="agreement" value="1"> 
						我已经认真阅读并同意 <<a href="#"><b>领航联盟服务协议</b></a>>
					</div>
					<div class="group">
						{!! csrf_field() !!}
						<input class="submit" type="submit" value="注册站长"/>
						<div class="login1">已有账号，<a href="/login"><b>点击登录</b></a></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection