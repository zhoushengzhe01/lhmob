<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">广告消耗</h3>
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

                    <el-form-item>
                        <el-input v-model="paramete.ads_id" placeholder="广告ID"></el-input>
                    </el-form-item>
                    
                    <el-form-item>
                        <el-input v-model="paramete.advertiser_id" placeholder="广告主ID"></el-input>
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
                    fixed="left"
                    prop="advertiser_id"
                    label="广告主ID"
                    min-width="80">
                </el-table-column>

                <el-table-column
                    prop="username"
                    label="用户名"
                    min-width="180">
                </el-table-column>

                <el-table-column
                    label="展示PV"
                    min-width="120">
                    <template slot-scope="scope">
                        展 {{scope.row.pv_number}}
                    </template>
                </el-table-column>

                <el-table-column
                    label="展示IP"
                    min-width="100">
                    <template slot-scope="scope">
                        展 {{scope.row.ip_number}}
                    </template>
                </el-table-column>

                <el-table-column
                    label="点击"
                    min-width="100">
                    <template slot-scope="scope">
                        点 {{scope.row.click_number}}
                    </template>
                </el-table-column>

                <el-table-column
                    label="点击率"
                    min-width="100">
                    <template slot-scope="scope">
                        {{ parseInt(scope.row.click_number / scope.row.pv_number * 10000)/100 }}%
                    </template>
                </el-table-column>

                <el-table-column
                    label="支出"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.out_money}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    label="消耗"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.money}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    prop="date"
                    label="时间"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    fixed="right"
                    prop="created_at"
                    label="操作时间"
                    min-width="160">
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

    </div>
</template>
<script>
export default {
    name: 'recharges',
    data: function () { 
        return {
            group: Group,
            loading: true,
            paramete: {
                offset: 0,
                limit: 15,
            },
            data: {},
        };
    },
    created: function () {
        
        this.group.page = window.location.pathname;

        this.getExpends();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getExpends: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/advertiser/expends.json', Th.paramete, function(data)
            {
                Th.data = data;
                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getExpends();
        },
        //-------------------------------------列表分页-------------------------------------
    },
}
</script>