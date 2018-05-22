<template>
<div id="app">
    <el-container style="height:100%">
        <el-header>
			<div class="left-logo">
				<img src="/website/images/logo.png"/>
			</div>
			<div class="right-userinfo">

				<router-link class="username" to="/advertiser/user">{{advertiser.username}} <i aria-hidden="true" class="fa fa-user-o"></i></router-link><a href="javascript:void(0)" class="loginout" @click="Logout()">退出登录</a>
			</div>
		</el-header>
        <el-container>
            <el-aside width="154px">
				<div class="money_box">
					账户余额：{{advertiser.money}} 元
					<br/>
					<a v-bind:href="'http://wpa.qq.com/msgrd?v=3&uin='+advertiser.busine.qq+'&site=qq&menu=yes'">客服 {{advertiser.busine.stagename}} <i class="fa fa-qq" aria-hidden="true"></i></a>
				</div>
				<br/>
				<el-menu
			      	background-color="#545c64"
			      	text-color="#fff"
			      	:default-active="group.page"
			      	:router="true"
			    	>
			      	<el-menu-item index="/advertiser">
			        	<i class="el-icon-menu"></i>
			        	<span slot="title">管理首页</span>
			      	</el-menu-item>

			     	<el-menu-item index="/advertiser/packages">
			        	<i class="el-icon-picture-outline"></i>
			        	<span slot="title">我的素材</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/ads">
			        	<i class="el-icon-news"></i>
			        	<span slot="title">广告管理</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/expends">
			        	<i class="el-icon-view"></i>
			        	<span slot="title">数据报表</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/recharges">
			        	<i class="el-icon-goods"></i>
			        	<span slot="title">充值记录</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/user">
			        	<i class="el-icon-edit-outline"></i>
			        	<span slot="title">个人信息</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/loginlogs">
			        	<i class="el-icon-date"></i>
			        	<span slot="title">登录日志</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/messages">
			        	<i class="el-icon-message"></i>
			        	<span slot="title">消息中心</span>
			      	</el-menu-item>

			      	<el-menu-item index="/advertiser/protocol">
			        	<i class="el-icon-document"></i>
			        	<span slot="title">投放协议</span>
			      	</el-menu-item>

			    </el-menu>

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
            
            Th.$api.put('advertiser/logout.json', {}, function(data){
                
                Th.message('success', '推出成功');

                window.location.href = '/login/ad';

            }, function(type, message){ Th.loading = false; Th.message(type, message) });
		},

		message: function(type, message){
            this.$message({ showClose: true, message: message, type: type });
            this.loading = false;
        }
	},
}
</script>