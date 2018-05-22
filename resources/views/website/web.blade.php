@extends('website.layout')

@section('content')
<!-- banner -->
<div class="banner-big" style="background: url({{$group->public}}images/advert_web.jpg) no-repeat; background-size: 100% 100%">
	<div class="text">
		<h1>丰富、海量的<b>广告资源</b>、快捷而高效的<b>流量变现</b></h1>
		<br/>
		<h3>日结不压款的站长的最好广告平台</h3>
	</div>
</div>


<!--流程-->
<div class="process">
	<div class="container">
		<br/>
		<div class="breadcrumb">
			当前位置：
			<a href="/"><b>首页</b></a> &nbsp;/
			<a href="/web">网站主</a>
		</div>
		<div class="content">
			<img src="{{$group->public}}images/liucheng_web.png">
		</div>
	</div>
</div>

<!--站长主-->
<div class="advert">
	<div class="container">
		<div class="main">
			<span class="action" data-id='con1'>资源丰富</span>
			<span data-id='con2'>智能系统</span>
			<span data-id='con3'>技术强大</span>
			<span data-id='con4'>公平公正</span>
			<span data-id='con5'>优质服务</span>
		</div>
		<div class="content">
			<div class="con action" id='con1'>
				<div class="left">
					<h3>资源丰富</h3>
					<p>领航移动联盟与海量优质广告主合作，覆盖游戏、电商、品牌等各类广告主数10万家以上，充足的广告资源确保广告拥有极高的填充率。同时严格把控广告质量，确保广告素材不影响用户体验。海量广告主和高品质的广告素材，既保证了广告的点击率，又能够提升开发者收益。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce6.jpg"></div>
			</div>
			<div class="con" id='con2'>
				<div class="left">
					<h3>智能系统</h3>
					<p>领航移动联盟的智能统计分析系统，为站长提供透明、实时的流量数据和收入数据，站长可随时监测。诚信为本，做站长最值得信赖的移动广告联盟。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce6.jpg"></div>
			</div>
			<div class="con" id='con3'>
				<div class="left">
					<h3>技术强大</h3>
					<p>领航移动联盟拥有业内领先的技术团队，对广告平台系统拥有独特的技术优势。强大的技术力量保证了系统的正常运行，同时能给站长的日常技术问题提供专业的解决方案。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce6.jpg"></div>
			</div>
			<div class="con" id='con4'>
				<div class="left">
					<h3>公平公正</h3>
					<p>领航移动联盟的智能统计分析系统，为网站主提供精确的数据依据。一方面，数据统计系统公平、透明计算广告收入，网站主可翔实监测；另一方面，数据统计系统也为网站主的优化提供参考。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce6.jpg"></div>
			</div>
			<div class="con" id='con5'>
				<div class="left">
					<h3>优质服务</h3>
					<p>领航移动联盟拥有专业的客服人员，保证新提交网站的快速审核。对于开发者广告费用提现审核及时响应快速到帐。同时，如果开发者有什么建议或意见我们也会及时跟进反馈。</p>
				</div>
				<div class="right"><img src="{{$group->public}}images/introduce6.jpg"></div>
			</div>
		</div>
		<a href="http://lhmob.cxmyq.com/register/web" class="botton">我有平台，立即注册赚钱</a>
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


