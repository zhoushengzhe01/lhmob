@extends('website.layout')

@section('content')
<!-- banner -->
<div class="banner-small" style="background: url({{$group->public}}images/notice_banner.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>公司动态</h1>
	</div>
</div>

<!--网站公告-->
<div class="container news" style="width:1024px;">
	
	<div class="breadcrumb">
		当前位置：
		<a href="/"><b>首页</b></a> &nbsp;/
		<a href="/news/dt">公司动态</a>
	</div>
	
	<ul class="list">
		@foreach ($news as $key=>$val)
		<li><a href="/new/{{$val->id}}">{{$val->title}}</a> <span class="time">{{$val->created_at}}</span></li>
		@endforeach
	</ul>

	{!! $news->links() !!}
</div>


@endsection