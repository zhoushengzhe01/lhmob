@extends('website.layout')

@section('content')
<!-- banner -->
<div class="banner-small" style="background: url({{$group->public}}images/notice_banner.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>{{$title}}</h1>
	</div>
</div>

<!--网站公告-->
<div class="container news" style="width:1024px;">

	<div class="breadcrumb">
		当前位置：
		<a href="/"><b>首页</b></a> &nbsp;/
		@if ($article->category_id=='1')
			<a href="/news/dt">{{$title}}</a>
		@elseif ($article->category_id=='2')
			<a href="/news/zx">{{$title}}</a>
		@elseif ($article->category_id=='3')
			<a href="/help">{{$title}}</a>
		@endif
	</div>

	<div class="list-item">
		<h1 style="text-align: center;font-size: 22px;">{{$article->title}}</h1>
		<div style="text-align: center;">时间：{{$article->created_at}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 来源：<a href="/">领航联盟</a></div>
		<br/>
		<div class="new_content">{!! $article->content !!}</div>
		<br/><br/>
	</div>
	<style>
		.new_content p{
			line-height: 36px;
    		margin-bottom: 8px;
		}
		.new_content a{
			color: #409eff;
		}
		.new_content b{
			font-weight: 700;
		}
	</style>

</div>
@endsection