<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">数据报表</h3>
        </div>

        <div class="box" v-loading="loadingday">

            <el-table :data="dataday.earnings" style="width: 100%">
                <el-table-column
                    prop="webmaster_id"
                    label="站长ID"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.webmaster_id}}：{{scope.row.myads_id}}
                    </template>
                </el-table-column>

                <el-table-column
                    prop="click"
                    label="点击量"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    prop="pv"
                    label="展示量"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    prop="money"
                    label="金额"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.money}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    prop="money"
                    label="点击率"
                    min-width="200">
                    <template slot-scope="scope">
                        {{ parseInt(scope.row.click / scope.row.pv * 10000)/100 }}%
                    </template>
                </el-table-column>
              
                <el-table-column
                    prop="date"
                    label="时间"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    v-bind:router="true"
                    fixed="right"
                    label="小时量"
                    width="100">
                    <template slot-scope="scope">
                        <el-button type="text" size="medium" @click="getEarningHour(scope.row)">列表</el-button>
                        <el-button type="text" size="medium" @click="getEarningHourChart(scope.row)">图表</el-button>
                    </template>
                </el-table-column>
            </el-table>

            <div class="page-box">
                <el-pagination
                @current-change="pageChangeDay"
                layout="total, prev, pager, next"
                :page-size="parameteday.limit"
                :total="dataday.count">
                </el-pagination>
            </div>
        </div>



        <!--弹窗编辑-->
        <el-dialog title="小时量" :visible.sync="show" class="big_dialog">

             <el-table :data="datahour.earnings" style="width: 100%" v-loading="loadinghour">
               
                <el-table-column
                    prop="click"
                    label="点击量"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    prop="pv"
                    label="展示量"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    prop="money"
                    label="金额"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.money}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    prop="money"
                    label="点击率"
                    min-width="80">
                    <template slot-scope="scope">
                        {{ parseInt(scope.row.click / scope.row.pv * 10000)/100 }}%
                    </template>
                </el-table-column>
              
                <el-table-column
                    prop="time"
                    label="时间"
                    min-width="160">
                </el-table-column>

            </el-table>

            <div class="page-box">
                <el-pagination
                @current-change="pageChangeHour"
                layout="total, prev, pager, next"
                :page-size="parametehour.limit"
                :total="datahour.count">
                </el-pagination>
            </div>

            <div slot="footer" class="dialog-footer">
                <el-button @click="show = false">关 闭</el-button>
            </div>
        </el-dialog>


        <el-dialog title="小时量" :visible.sync="chartshow" class="big_dialog">
            <x-chart :id="id" ref="chart"></x-chart>
            <div slot="footer" class="dialog-footer">
                <el-button @click="show = false">关 闭</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
import XChart from './../chart.vue'

export default {
    name: 'recharges',
    data: function () { 
        return {

            group: Group,
            show: false,
            chartshow: false,

            webmaster_ad_id: this.$route.params.webmaster_ad_id,

            loadingday: true,
            loadinghour: true,
            loadinghourchart: true,
            id: 'chart',

            dataday: {},
            datahour: {},
           
            parameteday: {
                offset: 0,
                limit: 15,
            },
            parametehour: {
                offset: 0,
                limit: 12,
            },
        };
    },
    created: function () {
        
        this.group.page = '/admin/webmaster/ads';

        this.getEarningDay();
    },
    components: {
        XChart
    },
    methods:{

        getEarningDay: function()
        {

            var Th = this;
            
            Th.loadingday = true;
            
            Th.$api.get('admin/webmaster/earning/day/'+Th.webmaster_ad_id+'.json', Th.parameteday, function(data)
            {
                Th.dataday = data;
                
                Th.loadingday = false;

            }, function(type, message){ Th.loadingday = false; Th.$emit('message', type, message); });
        },
        pageChangeDay: function(val) {
            this.parameteday.offset = parseInt(val-1) * parseInt(this.parameteday.limit);
            this.getEarningDay();
        },
        

        getEarningHour: function(row)
        {

            var Th = this;

            Th.loadinghour = true;

            Th.show = true;

            if(row)
            {
                Th.parametehour.date = row.date;
            }
            
            Th.$api.get('admin/webmaster/earning/hour/'+Th.webmaster_ad_id+'.json', Th.parametehour, function(data)
            {
                Th.datahour = data;
                
                Th.loadinghour = false;

            }, function(type, message){ Th.loadinghour = false; Th.$emit('message', type, message); });
        },
        pageChangeHour: function(val) {
            this.parametehour.offset = parseInt(val-1) * parseInt(this.parametehour.limit);
            this.getEarningHour('');
        },


        getEarningHourChart: function(row) {

            var Th = this;
            
            Th.chartshow = true;

            Th.loadinghourchart = true;

            Th.$api.get('admin/webmaster/earning/hour/chart/'+Th.webmaster_ad_id+'.json', { date: row.date, type: 2}, function(data){

                Th.initialHourChart(data);

                Th.loadinghourchart = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        initialHourChart: function(data)
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