<template>
<div class="content">

    <div class="title-box">
        <h3 class="title">管理首页</h3>
        <div class="search-box">
            <el-form :inline="true" :model="myads" class="demo-form-inline" size="mini">
                
                <el-form-item prop="region">
                    <el-select v-model="myads.myad_id" placeholder="切换广告" @change="getData">
                        <el-option label="全部数据" :value="0"></el-option>
                        <el-option v-for="item in myads.data" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item>
                    <router-link to="/webmaster/myads">
                        <el-button size="mini" type="primary">获取广告</el-button>
                    </router-link>
                    <router-link to="/webmaster/expends">
                        <el-button size="mini" type="primary">我的提现</el-button>
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
                            <div class="username">欢迎用户：<br/>{{group.webmaster.username}}</div>
                            <div class="logintime">上次登陆时间：<br/>{{group.webmaster.updated_at}}</div>
                        </div>
                    </div>
                </div>

            </el-col>
            <el-col :span="16">
                <div class="box" style="height: 200px;">
                    <h5>收益状况</h5>
                    <div class="earnings" v-if="data.week">
                        <div class="earning"><b>{{data.dayearnings.money}} 元</b><br/><span>今日收益</span></div>
                        <div class="earning"><b>{{data.yesterday.money}} 元</b><br/><span>昨日收益</span></div>
                        <div class="earning"><b>{{data.week.thisWeek.money}} 元</b><br/><span>本周收益</span></div>
                        <div class="earning"><b>{{data.week.lastWeek.money}} 元</b><br/><span>上周收益</span></div>
                    </div>
                </div>
            </el-col>
            
        </el-row>

        <el-row :gutter="24">
            <el-col :span="24">
                <div class="box">
                    <h5>两周收益</h5>
                    <div class="earningchart" v-loading="loading">
                        <x-chart :id="id" ref="chart"></x-chart>
                    </div>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="24">
            <el-col :span="24">
                <div class="box">
                    <h5>小时收益</h5>
                    <el-table
                    class="center"
                    v-loading="loadingTable"
                    :data="earning.earnings"
                    style="width: 100%;">

                        <el-table-column
                            prop="time"
                            label="时间">
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
                        :total="earning.count">
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

            myads: {
                myad_id: 0,
            },

            id: 'chart',
            data: {},

            paramete: {
                offset: 0,
                limit: 12,
            },
            earning: {},
        }
    },
    created: function () {
    
        this.group.page = '/webmaster';

        this.getMyads();

        this.getExpends();

    },
    components: {
        XChart
    },
    
    methods:{
        getMyads: function()
        {

            var Th = this;

            Th.$api.get('webmaster/myads.json', {}, function(data){
                
                Th.myads.data = data.myads;

                Th.getData();

            }, function(type, message){ Th.$emit('message', type, message); });

        },

        //--------------------------------------图表数据--------------------------------------
        getData: function() {

            var Th = this;
            
            Th.loading = true;

            Th.$api.get('webmaster/data.json', {myad_id: Th.myads.myad_id}, function(data){
                
                Th.data = data;

                Th.initialChart();

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        initialChart: function()
        {
            this.$refs.chart.init(this.data.weekearnings);
        },
        //--------------------------------------图表数据--------------------------------------




        //--------------------------------------图表数据--------------------------------------
        getExpends: function()
        {
            var Th = this;
            Th.loadingTable = true;
            Th.$api.get('webmaster/earnings/hour.json', Th.paramete, function(data)
            {
                Th.earning = data;

                Th.loadingTable = false;

            }, function(type, message){ Th.loadingTable = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getExpends();
        },
        //--------------------------------------图表数据--------------------------------------

    },
}
</script>