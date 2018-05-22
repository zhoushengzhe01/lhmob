<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta content="" name="description" />
    <meta content="webthemez" name="author" />
    <title>广告主后台-{{$title}}-{{$group['title']}}</title>
    <link href="/css/font-awesome.css" rel="stylesheet" />
    <link href="/css/style.css?20180105" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.js"></script>
</head>

<body>
<div id="wrapper">

    <div class="header">
        <div class="logo" style="height:100%; padding-bottom: 4px; padding-left: 6px;">
            <img src="/images/logo.png" style="height:100%">
        </div>
        <div class="tool">
            <a href="/advertiser/user" class="username">{{$group['advertiser']->username}} <i class="fa fa-user-o" aria-hidden="true"></i></a>
            <a href="/logout" class="loginout">退出登录</a>
        </div>
    </div>

    <div class="left">
        <div class="title">
            账户余额：{{$group['advertiser']->money}} 元<br/>
            <a href="http://wpa.qq.com/msgrd?v=3&uin={{$group['advertiser']['busine']->qq}}&site=qq&menu=yes">客服 {{$group['advertiser']['busine']->stagename}} <i class="fa fa-qq" aria-hidden="true"></i></a>
        </div>
        <div class="menu">
            <ul>
                <li @if ($title=='管理首页')class="action"@endif><a href="/advertiser"><i class="fa fa-dashboard" aria-hidden="true"></i> &nbsp;管理首页</a></li>
                <li @if ($title=='我的素材')class="action"@endif><a href="/advertiser/packages"><i class="fa fa-desktop" aria-hidden="true"></i> &nbsp;我的素材</a></li>
                <li @if ($title=='广告管理')class="action"@endif><a href="/advertiser/ads"><i class="fa fa-cubes" aria-hidden="true"></i> &nbsp;广告管理</a></li>
                <li @if ($title=='数据报表')class="action"@endif><a href="/advertiser/myads"><i class="fa fa-th-large" aria-hidden="true"></i> &nbsp;数据报表</a></li>
                <li @if ($title=='充值记录')class="action"@endif><a href="/advertiser/earnings/day"><i class="fa fa-briefcase" aria-hidden="true"></i> &nbsp;充值记录</a></li>
                <li @if ($title=='流量监控')class="action"@endif><a href="/advertiser/reward"><i class="fa fa-gift" aria-hidden="true"></i> &nbsp;流量监控</a></li>
                <!-- <li @if ($title=='奖励报表')class="action"@endif><a href="/advertiser/reward"><i class="fa fa-gift" aria-hidden="true"></i> &nbsp;来源网址</a></li> -->
                <li @if ($title=='个人信息')class="action"@endif><a href="/advertiser/user"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;个人信息</a></li>
                <!-- <li @if ($title=='修改密码')class="action"@endif><a href="/advertiser/passwd"><i class="fa fa-key fa-fw"></i> &nbsp;修改密码</a></li> -->
                <li @if ($title=='消息中心')class="action"@endif><a href="/notice"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp;消息中心</a></li>
            </ul>
        </div>
    </div>

    <div class="main">@yield('content')</div>

</div>
</body>
</html>