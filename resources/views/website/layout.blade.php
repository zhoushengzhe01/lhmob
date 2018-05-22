<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>{{$group->title}}-{{$title}}-{{$group->seo_title}}</title>

<meta name="keywords" content="{{$group->seo_keywords}}" />
<meta name="description" content="{{$group->seo_description}}" />
<link rel="stylesheet" href="{{$group->public}}css/css.css?201801010">
<link rel="stylesheet" href="/website/css/font-awesome.css?201801010">
<script src="{{$group->public}}script/build.js?201801010"></script>
</head>
<body>
	<!--头部菜单-->
	<header>
		<div class="container flex header">
			<div class="logo"><img src="{{$group->public}}images/logo.png" style="height:100%;width: 160px;"></div>
			<div class="flex menu">
				<a href="http://www.lhmob.cn/index" @if($title=='首页')class="on"@endif>首页</a>
				<a href="http://www.lhmob.cn/advert" @if($title=='广告主')class="on"@endif>广告主</a>
				<a href="http://www.lhmob.cn/web" @if($title=='网站主')class="on"@endif>网站主</a>
				<a href="http://www.lhmob.cn/news/dt" @if($title=='公司动态')class="on"@endif>公司动态</a>
				<a href="http://www.lhmob.cn/news/zx" @if($title=='行业资讯')class="on"@endif>行业资讯</a>
				<a href="http://www.lhmob.cn/help" @if($title=='最新动态')class="on"@endif>常见问题</a>
				<a href="http://lhmob.cxmyq.com/login/web" style="width:80px;">登录</a>
				<a href="http://lhmob.cxmyq.com/register/web" style="width:80px;">注册</a>
			</div>
		</div>
	</header>

	@yield('content')
	<div class="contact">
		<div class="container">
			<h2>联系我们</h2>
			<h3 class="subtitle"></h3>
			<div class="flex">
				<div class="flex-item service">
					<h4>网站主客服</h4>
					<div class="list">
						@foreach ($group->services as $key=>$val)
						<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$val['qq']}}&site=qq&menu=yes"><i class="fa fa-qq" aria-hidden="true"></i> {{$val['stagename']}}</a>
						@endforeach
					</div>
					<h4>广告主商务</h4>
					<div class="list">
						@foreach ($group->business as $key=>$val)
						<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$val['qq']}}&site=qq&menu=yes"><i class="fa fa-qq" aria-hidden="true"></i> {{$val['stagename']}}</a>
						@endforeach
					</div>
				</div>

				<div class="flex-item address">
					<div class="logo" style="margin-bottom: 0px;"><img src="{{$group->public}}images/logo.png" height="80"></div>
					<p>公司地址：浙江省杭州市西湖区紫霞街176号杭州互联网创新创业园2号楼11楼(310030)</p>
					<p>工作时间：上午9:30 ～ 下午18:00</p>
					<p>投诉建议：lhmobcn@163.com</p>

				</div>
			</div>
		</div>
	</div>

	<footer>Copyright  ©  2017-2018  杭州领航联盟科技有限公司  (lhmob.cn, Inc.) 版权所有</footer>

	<div class="footer tc">
		<div class="box"></div>
	</div>

<script type="text/javascript">


$(document).ready(function(){

    $(window).scroll(function (e) {

    	var top = $(document).scrollTop();

    	if(top>100)
    	{
    		$("header").attr('class', 'header_action');
    	}
    	else
    	{
    		$("header").attr('class', '');
    	}
    });

});

function message(type, message)
{
	var div = document.createElement('div');
		
	div.className = 'message '+type;

	div.innerHTML = '<div class="'+type+'">'+message+'</div>';

	document.body.appendChild(div);

	setTimeout(function()
	{
		$(div).remove();

	}, 3000);
}
</script>
</body>
</html>


