@extends('website.layout')

@section('content')
<!-- banner -->
<div class="banner-big" style="background: url({{$group->public}}images/advert_banner.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>创新、智能、高效、<b>精准</b>的互联网<b>广告营销</b>技术</h1>
		<br/>
		<h3>为广告主赢得最大化的收益</h3>
	</div>
</div>

<!--流程-->
<div class="process">
	<div class="container">
		<br/>
		<div class="breadcrumb">
			当前位置：
			<a href="{{$group->url}}/"><b>首页</b></a> &nbsp;/
			<a href="{{$group->url}}/advert">广告主</a>
		</div>

		<div class="content">
			<img src="{{$group->public}}images/liucheng_ads.png">
		</div>
	</div>
</div>

<!--广告资源-->
<div class="advert">
	<div class="container">

		<div class="main">
			<span class="action" data-id='con1'>广告形式</span>
			<span data-id='con2'>计费模式</span>
			<span data-id='con3'>效果监控</span>
			<span data-id='con4'>精准投放</span>
			<span data-id='con5'>节约成本</span>
		</div>
		<div class="content">
			<div class="con action" id='con1'>
				<div class="left">
					<h3>广告形式</h3>
					<p>领航移动联盟提供覆盖市面主流样式的合作，包括插屏广告、通栏广告、漂浮广告、悬浮广告、弹窗广告等多种广告展现形式。同时，领航移动联盟在样式创新的道路上走在行业最前沿。凭借丰富的信息流广告经验，独创原生广告样式，使广告与播放环境高度融合，即能形成一致的用户体验，达到最好的宣传效果。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce1.jpg"></div>
			</div>
			<div class="con" id='con2'>
				<div class="left">
					<h3>计费模式</h3>
					<p>CPM (弹窗付费)、CPC (点击付费)、CPV (显示效果付费)、CPS (成功销售付费)、CPA (有效注册付费)多种广告投放方式及计费模式，广告主自由选择，满足投放需求。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce2.jpg"></div>
			</div>
			<div class="con" id='con3'>
				<div class="left">
					<h3>效果监控</h3>
					<p>在广告投上线后，可以对已经投放的广告进行效果监控，分析广告投放效果，进行灵活性的调整，广告内容与网站类型的相关程度调整， 费用预算等等。广告投放期间可以针对目标群的浏览高低峰，对广告进行24小时的时间段显示，智能化管理，只要选择时间段投放就会自动上下线自己的广告。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce3.jpg"></div>
			</div>
			<div class="con" id='con4'>
				<div class="left">
					<h3>精准投放</h3>
					<p>通过IP地址及Cookie技术，网络广告主可以根据个人不同的差别将受众分类，以细分化的有差别的市场策略， 确立品牌位置，将广告信息准确发送给目标用户，以求得最佳效果，同时避免广告费的浪费。领航移动联盟为广告主提供了丰富的网络媒体，对你的广告进行分类的投放，定向常浏览的目标群。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce4.jpg"></div>
			</div>
			<div class="con" id='con5'>
				<div class="left">
					<h3>节约成本</h3>
					<p>领航移动联盟用专业的技术为您精打细算，花费比传统广告低廉数倍的费用，收获比传统广告多数倍的效果！过万的各种类型的网站资源，迅速帮助广告主提升品牌知名度，创造广告效益，帮助企业网站提升访问量，提升网站收益。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce5.jpg"></div>
			</div>
		</div>
		<a href="http://lhmob.cxmyq.com/register/ad" class="botton">我是广告主，立即注册投放广告</a>
	</div>
</div>

<script>
$(function(){
	$(".advert .main span").mouseover(function(){
		
		$(".advert .main span").attr('class', '');
		$(this).attr('class', 'action');

		$(".advert .content .con").attr('class', 'con');
		$("#"+$(this).data('id')).attr('class', 'con action');

	})
})
</script>
@endsection