<template>
<div class="content">
    <div class="title-box">
        <h3 class="title">管理首页</h3>
        <div class="search-box">
            <el-form :inline="true" :model="paramete2" class="demo-form-inline" size="mini">
                
                <el-form-item prop="region">
                    <el-select v-model="paramete2.myad_id" placeholder="切换广告" @change="getData">
                        <el-option label="全部数据" :value="0"></el-option>
                        <el-option v-for="item in myads" :label="item.title" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item>
                    <router-link to="/advertiser/recharges">
                        <el-button size="mini" type="primary">充值记录</el-button>
                    </router-link>
                    <router-link to="/advertiser/expends">
                        <el-button size="mini" type="primary">数据报表</el-button>
                    </router-link>
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
                            <div class="username">欢迎用户：<br/>{{group.advertiser.username}}</div>
                            <div class="logintime">上次登陆时间：<br/>{{group.advertiser.updated_at}}</div>
                        </div>
                    </div>
                </div>

            </el-col>
            <el-col :span="16">
                <div class="box" style="height: 200px;">
                    <h5>消耗状况</h5>
                    <div class="earnings" v-if="data.week">
                        <div class="earning"><b>{{data.dayexpends.money}} 元</b><br/><span>今日消耗</span></div>
                        <div class="earning"><b>{{data.yesterday.money}} 元</b><br/><span>昨日消耗</span></div>
                        <div class="earning"><b>{{data.week.thisWeek.money}} 元</b><br/><span>本周消耗</span></div>
                        <div class="earning"><b>{{data.week.lastWeek.money}} 元</b><br/><span>上周消耗</span></div>
                    </div>
                </div>
            </el-col>
            
        </el-row>

        <el-row :gutter="24">
            <el-col :span="24">
                <div class="box">
                    <h5>两周消耗</h5>
                    <div class="earningchart" v-loading="loading">
                        <x-chart :id="id" ref="chart"></x-chart>
                    </div>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="24">
            <el-col :span="24">
                <div class="box">
                    <h5>小时消耗</h5>
                    <el-table
                    class="center"
                    v-loading="loadingTable"
                    :data="expend.expends"
                    style="width: 100%;">

                        <el-table-column
                            prop="time"
                            label="时间">
                        </el-table-column>

                        <el-table-column
                            prop="pv_number"
                            label="展示">
                        </el-table-column>

                        <el-table-column
                            prop="click_number"
                            label="点击">
                        </el-table-column>

                        <el-table-column
                            prop="money"
                            label="金额">
                            <template slot-scope="scope">
                                {{scope.row.money}} 元
                            </template>
                        </el-table-column>
                    </el-table>
                    <div class="page-box">
                        <el-pagination
                        @current-change="pageChange"
                        layout="total, prev, pager, next"
                        :page-size="paramete.limit"
                        :total="expend.count">
                        </el-pagination>
                    </div>

                </div>

            </el-col>

        </el-row>

    </div>

    
</div>
</template>
<script>

import XChart from './chart.vue'

export default {
    name: 'home',
    data: function () {	
        return {
            group: Group,
            loading: true,
            loadingTable: true,

            paramete2: {
                myad_id: 0,
            },
            myads: {},
            
            
            id: 'chart',
            data: {},

            paramete: {
                offset: 0,
                limit: 12,
            },
            expend: {},
        }
    },
    created: function () {
    
        this.group.page = '/advertiser';

        this.getData();

        this.getMyads();

        this.getExpends();

    },
    components: {
        XChart
    },
    
    methods:{
        //--------------------------------------图表数据--------------------------------------
        getData: function() {

            var Th = this;
            
            Th.loading = true;

            Th.$api.get('advertiser/data.json', {myad_id: Th.paramete2.myad_id}, function(data){
                
                Th.data = data;

                Th.initialChart();

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        initialChart: function()
        {
            this.$refs.chart.init(this.data.weekexpends);
        },
        //--------------------------------------图表数据--------------------------------------



        //--------------------------------------图表数据--------------------------------------
        getExpends: function()
        {
            var Th = this;
            
            Th.loadingTable = true;

            Th.$api.get('advertiser/expends/hour.json', Th.paramete, function(data)
            {
                Th.expend = data;

                Th.loadingTable = false;

            }, function(type, message){ Th.loadingTable = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getExpends();
        },
        //--------------------------------------图表数据--------------------------------------



        getMyads: function()
        {
            var Th = this;

            Th.$api.get('advertiser/ads.json', {}, function(data){
                
                Th.myads = data.ads;

            }, function(type, message){ Th.$emit('message', type, message); });

        },


    },
}

</script>