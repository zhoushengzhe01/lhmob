<template>   
<div class="content">
    <div class="title-box">
        <h3 class="title">管理首页</h3>
        <div class="search-box">
            
            <el-form :inline="true" :model="paramete2" class="demo-form-inline" size="mini">

                <el-form-item prop="region">

                    <el-tooltip class="item" effect="dark" :content="'http://lhmob.cxmyq.com/register/'+group.user.id" placement="bottom">
                        <el-button>推广地址</el-button>
                    </el-tooltip>

                    <el-select v-model="paramete2.myad_id" placeholder="切换广告">
                        <el-option label="全部数据" :value="0"></el-option>
                        <el-option v-for="item in group.adsType" :label="item.label" :value="item.value"></el-option>
                    </el-select>

                    <el-badge is-dot class="item">
                        <el-button type="primary">结算</el-button>
                    </el-badge>

                    <el-badge is-dot class="item">
                        <el-button type="primary">充值</el-button>
                    </el-badge>

                    <el-badge is-dot class="item">
                        <el-button type="primary">审核</el-button>
                    </el-badge>

                </el-form-item>

            </el-form>

        </div>

    </div>

    <div class="homePage">
    <el-row :gutter="24">
        <el-col :span="8">
            <div class="box">
                <h5>账户信息</h5>
                <div class="userinfo">
                    <div class="people">
                        <div class="people_header"></div>
                        <div class="people_body">&nbsp;&nbsp;&nbsp;</div>
                    </div>
                    <div class="user">
                        <div class="username">欢迎用户：周胜哲</div>
                        
                        <div class="logintime">登陆时间：<br/>2018-04-20 15:03:04</div>
                    </div>
                </div>
            </div>

        </el-col>
        <el-col :span="16">
            <div class="box" style="height: 200px;">
                <h5>广告情况</h5>
                <div class="earnings">
                    <div class="earning"><b>2000 元</b><br/><span>今日消耗</span></div>
                    <div class="earning"><b>2000 元</b><br/><span>站长费用</span></div>
                    <div class="earning"><b>30 条</b><br/><span>WAP广告</span></div>
                    <div class="earning"><b>10 条</b><br/><span>微信广告</span></div>
                </div>
            </div>
        </el-col>
    </el-row>

    <el-row :gutter="24">
        <el-col :span="24">
            <div class="box">
                <h5>小时分布图</h5>
                <x-chart :id="id" ref="chart"></x-chart>
            </div>
        </el-col>
    </el-row>



    </div>
</div>
</template>

<script>
import XChart from './chart.vue'

export default {
    name: 'user',
    data: function () { 
        return {
            group: Group,

            paramete2: {
                myad_id: 0,
            },
            myads: {},

            id: 'chart',
            webmasterEarning: {},
            parameteWebmaster: {},
            loadingWebmaster: true,
        };
    },
    created: function () {
        
        this.group.page = "/admin";

        this.getWebmasterEarning();
        
    },
    components: {
        XChart
    },
    methods:{
        getWebmasterEarning: function() {

            var Th = this;

            Th.loadingWebmaster = true;

            Th.$api.get('admin/home/webmaster/earning/hour.json', Th.parameteWebmaster, function(data){

                Th.initWebmasterEarning(data);

                Th.loadingWebmaster = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        initWebmasterEarning: function(data)
        {  

            var today = [];
            var yesterday = [];

            //今天
            for(var index in data.today)
            {
                today[index] = data.today[index].pv;
            }

            //昨天
            for(var index in data.yesterday)
            {
                yesterday[index] = data.yesterday[index].pv;
            }

            var seriesData = [{
                color: '#CCCCCC',
                name: '昨天',
                data: yesterday,
            }, {
                color: '#409EFF',
                name: '今日',
                data: today,
            }];


            this.$refs.chart.init(data.default, seriesData);
        },
    },
}
</script>