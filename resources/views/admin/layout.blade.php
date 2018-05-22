<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta content="" name="description" />
    <meta content="webthemez" name="author" />
    <title>管理后台</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
	
	<!-- <script src="/script/jquery.min.js"></script> -->

	<!-- 表格响应式插件 - FooTable -->
    <!-- <link href="//cdn.bootcss.com/jquery-footable/2.0.3/css/footable.core.css" rel="stylesheet"> -->
	<!-- 表格响应式插件 - FooTable -->
	<!-- <script src="//cdn.bootcss.com/jquery-footable/2.0.3/js/footable.all.min.js"></script> -->
	<!-- 时间控件 -->
	<script src="/script/laydate.js"></script>

    <link href="/css/font-awesome.css" rel="stylesheet" />
    <link href="/css/admin.css?20180105" rel="stylesheet"/>
</head>

<body>
<div id="wrapper">
    
    <div class="left">
		<div class="logo">
            <img src="/images/logo.png" style="height:100%">
        </div>
        <div class="title">
			{{$global->date}} 星期{{$global->week}}
           	<br/>
            <a href="/admin/userinfo">{{$global->user->nickname}}</a>&nbsp;&nbsp;<a>推出</a>
        </div>
        <div class="menu">
			<ul class="nav">
				@foreach ($global->navigation as $key=>$val)
				<li class="menu_item @if($val->mark==$position[0]) @if($val->list) show @else action @endif @endif">

					<a class="fa {{$val->icon}}" @if($val->list) onclick="show_menu(this)" @else href="{{$global->url}}{{$val->url}}" @endif>&nbsp; {{$val->name}} @if($val->list)<i class="fa fa-angle-left"></i>@endif</a>
					
					@if ($val->list)
					<ul class="nav nav-second-level">

						@foreach ($val->list as $k=>$v)
						
						<li class="@if($v->mark==$position[1]) action @endif"><a href="{{$global->url}}{{$v->url}}">{{$v->name}}</a></li>
						
						@endforeach

					</ul>
					@endif

				</li>
				@endforeach
			</ul>
        </div>
	</div>
	<script>
		function show_menu(_this)
		{
			var is_there = $(_this).parent().hasClass('show')
			
			$('.menu_item').removeClass('show');

			if(!is_there)
			{
				$(_this).parent().addClass('show');
			}
		}
	</script>

    <div class="main">@yield('content')</div>

</div>
</body>
</html>