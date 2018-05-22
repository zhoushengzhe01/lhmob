<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta content="" name="description" />
    <meta content="webthemez" name="author" />
    <title>站长后台-{{$title}}-{{$website->title}}</title>
    <link href="/css/font-awesome.css" rel="stylesheet" />
    <link href="/css/style.css?20180105" rel="stylesheet"/>
    <script src="/script/jquery.min.js"></script>
    
</head>

<body>
<div id="wrapper">

    <div class="header">
        <div class="logo" style="height:100%; padding-bottom: 4px; padding-left: 6px;">
            <img src="/images/logo.png" style="height:100%">
        </div>
        <div class="tool">
            <a href="/webmaster/user" class="username">{{$webmaster->username}} <i class="fa fa-user-o" aria-hidden="true"></i></a>
            <a href="/logout" class="loginout">退出登录</a>
        </div>
    </div>

    <div class="left">
        <div class="title">
            账户余额：{{$webmaster->money + $webmaster->hour_money + $webmaster->minute_money}} 元<br/>
            <a href="http://wpa.qq.com/msgrd?v=3&uin={{$webmaster->service->qq}}&site=qq&menu=yes">客服 {{$webmaster->service->stagename}} <i class="fa fa-qq" aria-hidden="true"></i></a>
        </div>
        <div class="menu">
            <ul>
                <li @if ($title=='管理首页')class="action"@endif><a href="/webmaster"><i class="fa fa-dashboard" aria-hidden="true"></i> &nbsp;管理首页</a></li>
                <li @if ($title=='网站管理')class="action"@endif><a href="/webmaster/website"><i class="fa fa-desktop" aria-hidden="true"></i> &nbsp;网站管理</a></li>
                <li @if ($title=='推荐广告')class="action"@endif><a href="/webmaster/ads"><i class="fa fa-cubes" aria-hidden="true"></i> &nbsp;推荐广告</a></li>
                <li @if ($title=='我的广告')class="action"@endif><a href="/webmaster/myads"><i class="fa fa-th-large" aria-hidden="true"></i> &nbsp;我的广告</a></li>
                <li @if ($title=='佣金报表')class="action"@endif><a href="/webmaster/earnings/day"><i class="fa fa-briefcase" aria-hidden="true"></i> &nbsp;佣金报表</a></li>
                <li @if ($title=='奖励报表')class="action"@endif><a href="/webmaster/reward"><i class="fa fa-gift" aria-hidden="true"></i> &nbsp;奖励报表</a></li>
                <li @if ($title=='财务结算')class="action"@endif><a href="/webmaster/money"><i class="fa fa-credit-card" aria-hidden="true"></i> &nbsp;财务结算</a></li>
                <li @if ($title=='个人信息')class="action"@endif><a href="/webmaster/user"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;个人信息</a></li>
                <li @if ($title=='修改密码')class="action"@endif><a href="/webmaster/passwd"><i class="fa fa-key fa-fw"></i> &nbsp;修改密码</a></li>
                <li @if ($title=='消息中心')class="action"@endif><a href="/notice"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp;消息中心</a></li>
            </ul>
        </div>
    </div>

    <div class="main">@yield('content')</div>

</div>
</body>
</html>