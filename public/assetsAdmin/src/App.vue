<template>
<div id="app">
    <el-container>
        <el-container>
            <el-aside width="168px">
	            <el-row class="tac">

	            	<div class="logo">
						<img src="/website/images/logo.png"/>
					</div>

					<div class="money_box">
						04月07日 星期三
						<br/>
						<router-link to="/admin/user">欢迎 "{{group.user.nickname}}"</router-link>
					</div>
					<br/>


				    <el-menu
				      	background-color="#545c64"
				      	text-color="#fff"
				      	:default-active="group.page"
				      	:router="true"
				    	>
				      	<el-menu-item index="/admin">
				        	<i class="el-icon-menu"></i>
				        	<span slot="title">管理首页</span>
				      	</el-menu-item>

				      	<el-submenu index="webmaster">
				        	<template slot="title">
				          		<i class="el-icon-share"></i>
				          		<span>站长管理</span>
				        	</template>
				        	<el-menu-item index="/admin/webmasters">站长会员</el-menu-item>
				          	<el-menu-item index="/admin/webmaster/ads">站长广告</el-menu-item>
				          	<el-menu-item index="/admin/webmaster/websites">网站管理</el-menu-item>
				          	<el-menu-item index="/admin/webmaster/categorys">网站分类</el-menu-item>
				          	<el-menu-item index="/admin/webmaster/moneys">余额变动</el-menu-item>
				          	<el-menu-item index="/admin/webmaster/loginlogs">登录日志</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="alliance">
				        	<template slot="title">
				          		<i class="el-icon-tickets"></i>
				          		<span>联盟广告</span>
				        	</template>
				        	<el-menu-item index="/admin/alliances">线上联盟</el-menu-item>
				          	<el-menu-item index="/admin/alliance/spendings">联盟支出</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="advertiser">
				        	<template slot="title">
				          		<i class="el-icon-news"></i>
				          		<span>广告管理</span>
				        	</template>
				        	<el-menu-item index="/admin/advertisers">广告主管理</el-menu-item>
				          	<el-menu-item index="/admin/advertiser/ads">广告管理</el-menu-item>
				          	<el-menu-item index="/admin/advertiser/consumes">广告消耗</el-menu-item>
				          	<el-menu-item index="/admin/advertiser/packages">素材管理</el-menu-item>
				          	<el-menu-item index="/admin/advertiser/loginlogs">登录日志</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="flux">
				        	<template slot="title">
				          		<i class="el-icon-tickets"></i>
				          		<span>联盟流量</span>
				        	</template>
				        	<el-menu-item index="/admin/alliance/fluxs">联盟流量</el-menu-item>
				          	<el-menu-item index="/admin/alliance/flux/expends">流量消耗</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="property">
				        	<template slot="title">
				          		<i class="el-icon-goods"></i>
				          		<span>财务管理</span>
				        	</template>
				        	<el-menu-item index="/admin/property/takemoneys">站长提现</el-menu-item>
				          	<el-menu-item index="/admin/property/rewards">站长奖励</el-menu-item>
				          	<el-menu-item index="/admin/property/recharges">广告充值</el-menu-item>
				          	<el-menu-item index="/admin/property/service/earnings">媒介提成</el-menu-item>
				          	<el-menu-item index="/admin/property/busine/earnings">商务提成</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="user">
				        	<template slot="title">
				          		<i class="el-icon-location-outline"></i>
				          		<span>会员管理</span>
				        	</template>
				        	<el-menu-item index="/admin/users">员工管理</el-menu-item>
				          	<el-menu-item index="/admin/departments">部门管理</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="article">
				        	<template slot="title">
				          		<i class="el-icon-location-outline"></i>
				          		<span>文章管理</span>
				        	</template>
				        	<el-menu-item index="/admin/articles">文章列表</el-menu-item>
				          	<el-menu-item index="/admin/article/categorys">文章分类</el-menu-item>
				     	</el-submenu>

				     	<el-submenu index="customer">
				        	<template slot="title">
				          		<i class="el-icon-location-outline"></i>
				          		<span>客户管理</span>
				        	</template>
				        	<el-menu-item index="/admin/customers">客户管理</el-menu-item>
				          	<el-menu-item index="/admin/customers/sources">来源管理</el-menu-item>
				          	<el-menu-item index="/admin/mails">系统邮件</el-menu-item>
				     	</el-submenu>

				     	<el-menu-item index="/admin/setting">
				        	<i class="el-icon-setting"></i>
				        	<span slot="title">系统设置</span>
				      	</el-menu-item>

				      	<el-menu-item index="/admin/messages">
				        	<i class="el-icon-message"></i>
				        	<span slot="title">消息中心</span>
				      	</el-menu-item>

				      	<el-menu-item index="/admin/user">
				        	<i class="el-icon-edit-outline"></i>
				        	<span slot="title">个人资料</span>
				      	</el-menu-item>

				    </el-menu>

				</el-row>

			</el-aside>

            <el-container>
            	<el-main>
					<router-view @message="message"></router-view>
				</el-main>
              	<el-footer>Copyright © 2017-2018 杭州领航联盟科技有限公司 (lhmob.cn, Inc.) 版权所有</el-footer>
        	</el-container>
    	</el-container>
    </el-container>
</div>
</template>

<script>
export default {
	name: 'app',
	data: function () {	
		return {
			isActive: true,
			group: Group,
			advertiser: Group.advertiser,		
		};
	},
	created: function () {

	},
	methods:{
		Logout: function()
		{
			var Th = this;

            Th.loading = true;

            Th.$api.put('webmaster/logout.json', {}, function(data){
                
                Th.message('success', '推出成功');

                window.location.href = '/login/web';

            }, function(type, message){ Th.message(type, message) });
		},

		message: function(type, message){
            this.$message({ showClose: true, message: message, type: type });
            this.loading = false;
        }
	},
}
</script>