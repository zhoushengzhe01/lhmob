<template>
<div class="content">
    <div class="title-box">
        <h3 class="title" v-if="type=='day'">每日报表</h3>
        <h3 class="title" v-if="type=='hour'">小时报表</h3>
        <div class="search-box">
            <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">

                <el-form-item placeholder="选择日期">
                    <el-date-picker
                        value-format="yyyy-MM-dd"
                        type="date"
                        placeholder="选择日期"
                        v-model="paramete.date"
                        style="width: 100%;"
                    ></el-date-picker>
                </el-form-item>
            
                <el-form-item label="">
                    <el-select v-model="paramete.ads_id" placeholder="我的广告">
                        <el-option
                            v-for="item in ads"
                            :label="item.title"
                            :value="item.id"
                            :disabled="item.disabled">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="getExpends">查询</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>

    <div class="box" v-loading="loading">

        <el-table :data="data.expends" style="width: 100%">
            <el-table-column
                prop="id"
                label="广告ID"
                min-width="80">
            </el-table-column>

            <el-table-column
                prop="pv_number"
                label="展示量"
                min-width="100">
            </el-table-column>

            <el-table-column
                prop="ip_number"
                label="IP量"
                min-width="100">
            </el-table-column>

            <el-table-column
                prop="click_number"
                label="点击量"
                min-width="100">
            </el-table-column>

            <el-table-column
                label="点击率"
                min-width="220">
                <template slot-scope="scope">
                    <el-progress v-if="scope.row.click_number!=0 && scope.row.pv_number!=0" :text-inside="true" :stroke-width="18" :percentage="parseInt(scope.row.click_number / scope.row.pv_number * 100)" style="width: 80%;"></el-progress>

                    <el-progress v-if="scope.row.click_number==0 || scope.row.pv_number==0" :text-inside="true" :stroke-width="18" :percentage="0" style="width: 80%;"></el-progress>

                </template>
            </el-table-column>

            <el-table-column
                label="消耗"
                min-width="120">
                <template slot-scope="scope">
                    {{scope.row.money}}元
                </template>
            </el-table-column>

            <!-- <el-table-column
                label="千点击"
                min-width="120">
                <template slot-scope="scope">
                    120元
                </template>
            </el-table-column> -->

            <el-table-column
                prop="created_at"
                label="时间"
                min-width="200">
            </el-table-column>

            <el-table-column
                v-bind:router="true"
                fixed="right"
                label="操作"
                width="100">
                <template slot-scope="scope">
                
                    <el-button type="text" size="small" @click="getHourExpends">小时量</el-button>
                
                </template>
            </el-table-column>
        </el-table>

        <div class="page-box">
            <el-pagination
            @current-change="pageChange"
            layout="total, prev, pager, next"
            :page-size="paramete.limit"
            :total="data.count">
            </el-pagination>
        </div>
    </div>


    <!--小时量弹出-->
    <el-dialog title="小时数据" label-position="top" :visible.sync="show" width="600px">

        <div v-loading="hourLoading">
            <el-table :data="hourdata.expends" style="width: 100%">

                <el-table-column
                    prop="pv_number"
                    label="展示"
                    min-width="60">
                </el-table-column>

                <el-table-column
                    prop="ip_number"
                    label="IP量"
                    min-width="60">
                </el-table-column>

                <el-table-column
                    prop="click_number"
                    label="点击"
                    min-width="60">
                </el-table-column>

               
                <el-table-column
                    label="消耗"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.money}}元
                    </template>
                </el-table-column>


                <el-table-column
                    prop="created_at"
                    label="时间"
                    min-width="160">
                </el-table-column>
            </el-table>

            <div class="page-box">
                <el-pagination
                @current-change="getHourExpends"
                layout="total, prev, pager, next"
                :page-size="paramete.limit"
                :total="hourdata.count">
                </el-pagination>
            </div>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button type="primary" @click="show = false">关闭</el-button>
        </div>
    
    </el-dialog>

  </div>
</template>
<script>
export default {
    name: 'expends',
    data: function () { 
        return {
            group: Group,
            loading: true,
            ads: {},
            type: 'day',
            paramete: {
                offset: 0,
                limit: 10,
            },
            data: {},

            hourParamete: {
                offset: 0,
                limit: 6,
            },
            hourdata: {},
            hourLoading: true,
            show: false,
        };
    },
    created: function () {
        
        this.group.page = '/advertiser/expends';

        this.getExpends();

        this.getAds();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getExpends: function()
        {
            var Th = this;
            
            Th.loading = true;

            Th.$api.get('advertiser/expends/day.json', Th.paramete, function(data)
            {
                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val)
        {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getExpends();
        },
        //-------------------------------------列表分页-------------------------------------

        //-------------------------------------列表分页-------------------------------------
        getHourExpends: function()
        {
            var Th = this;
            
            Th.hourLoading = true;
            
            Th.show = true;

            Th.$api.get('advertiser/expends/hour.json', Th.hourParamete, function(data)
            {
                Th.hourdata = data;
            
                Th.hourLoading = false;

            }, function(type, message){ Th.hourLoading = false; Th.$emit('message', type, message); });
        },
        pageHourChange: function(val)
        {
            this.hourParamete.offset = parseInt(val-1) * parseInt(this.hourParamete.limit);
            this.getHourExpends();
        },
        //-------------------------------------列表分页-------------------------------------


        getAds: function()
        {
            var Th = this;
            Th.$api.get('advertiser/ads.json',Th.data.paramete, function(data)
            {
                Th.ads = data.ads;

            }, function(type, message){ Th.$emit('message', type, message); });
        },

    },
}
</script>