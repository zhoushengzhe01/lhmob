@extends('website.layout')

@section('content')
<!-- banner -->
<div class="banner-big" style="background: url({{$group->public}}images/index_banner.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>专业、可靠、稳定、精准的<b>移动广告</b>、一站式投放平台</h1>
		<br/>
		<h3>高效的推广形式、最大化的广告效果</h3>
	</div>
</div>

<!--  我们的优势 -->
<div class="advantage">
	<div class="container">
		<h2>我们的优势，我们能做什么？</h2>
		<h3 class="subtitle">覆盖全行业广告主，超高收益！每天超过上亿次展示，精准定向投放，以效果说话！</h3>
		<div class="content">
			<div class="item">
				<img src="{{$group->public}}images/advantage1.jpg">
				<h3>覆盖全国海量用户</h3>
				<p>领航移动依靠对海量媒体的聚合与梳理，为广告主提供有效的移动广告受众高度覆盖，最少投入带来最好的投放效果。</p>
			</div>

			<div class="item">
				<img src="{{$group->public}}images/advantage2.jpg">
				<h3>多重广告解决方案</h3>
				<p>领航移动拥有丰富的广告展现，极大地提高广告投放推广成效。为广告制定最合适的广告展现形式，以吸引目标受众进行交互，从而达到最佳的推广效果。</p>
			</div>

			<div class="item">
				<img src="{{$group->public}}images/advantage3.jpg">
				<h3>广告资源丰富</h3>
				<p>领航移动与众多知名广告商进行合作，拥有丰富的高质量广告资源，保证广告填充率，提高网站主收益。</p>
			</div>

			<div class="item">
				<img src="{{$group->public}}images/advantage4.jpg">
				<h3>精准定位到用户行为投放</h3>
				<p>领航移动拥有独特的先进数据挖掘技术，精准挖掘用户群，实现传播效果最大化，满足广告主的精确投放需求。</p>
			</div>
		</div>
	</div>
</div>

<!--我们的广告形式-->
<div class="species">
	<div class="container">
		<h2>我们的广告形式</h2>
		<h3 class="subtitle">开启2018广告形式新时代，多种广告形式任你挑选！</h3>
		<div class="content">
			<div class="image">
				<img id="ad1" class="action" src="{{$group->public}}images/ad1.jpg">
				<img id="ad2" src="{{$group->public}}images/ad2.jpg">
				<img id="ad3" src="{{$group->public}}images/ad3.jpg">
				<img id="ad4" src="{{$group->public}}images/ad4.jpg">
				<img id="ad5" src="{{$group->public}}images/ad5.jpg">
			</div>
			<div class="title">
				<div class="item action item1" data-id="ad1">通栏广告<span>以通栏的形式展现具有稳定的填充和收益</span></div>
				<div class="item item2" data-id="ad2">插屏广告<span>半屏式的漂窗类广告良好的用户体验</span></div>
				<div class="item item3" data-id="ad3">横幅广告<span>作为应用的一部分与网页高度融合的广告</span></div>
				<div class="item item4" data-id="ad4">跳转广告<span>全屏的弹窗类广告全屏的广告形式</span></div>
				<div class="item item5" data-id="ad5">图文广告<span>列表、橱窗形式展现更多的广告曝光</span></div>
			</div>
		</div>
	</div>
</div>

<!--帮助中心-->
<div class="help">
	<div class="container">
		<h2>公司动态</h2>
		<h3 class="subtitle">解决你的问题，是我们长期合作的基础！</h3>
		<div class="content">
			<div class="announcement">
				<h3>公司动态 <a class="more" href="/news/dt">更多》</a></h3>
				<ul class="mod-list">
					@foreach ($news as $key=>$val)
					<li><span>{{$val->created_at}}</span><a href="/new/{{$val->id}}">{{$val->title}}</a></li>
					@endforeach
				</ul>
			</div>
			<div class="problem">
				<h3>行业资讯 <a class="more" href="/news/zx">更多》</a></h3>
				<ul class="mod-list">
					@foreach ($helps as $key=>$val)
					<li><span>{{$val->created_at}}</span><a href="/new/{{$val->id}}">{{$val->title}}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>

<!--我们的客户-->
<div class="customer">
	<div class="container">
		<h2>我们的客户</h2>
		<h3 class="subtitle">成功源于客户，客户需求是我们努力的方向！</h3>
		<div class="content">
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer1.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer2.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer3.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer4.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer5.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer6.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer7.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer8.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer9.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer10.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer11.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer12.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer13.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer14.jpg"></a>
			<a href="javascript:void(0)"><img src="{{$group->public}}images/customer15.jpg"></a>
		</div>
	</div>
</div>


<script>

	$(".species .content .title .item").mouseover(function(){
		$(".species .content .title .item").removeClass("action");
		$(this).addClass("action");

		$(".species .content .image img").removeClass("action");
		$("#"+$(this).data('id')).addClass("action");
	})
</script>
@endsection