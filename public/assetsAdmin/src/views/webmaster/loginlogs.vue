<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">站长会员</h3>
            <div class="search-box">
                <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">
                    <el-form-item>
                        <el-input v-model="paramete.webmaster_id" placeholder="站长ID"></el-input>
                    </el-form-item>
                    
                    <el-form-item>
                        <el-button type="primary" @click="getLoginlogs">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="box" v-loading="loading">

            <el-table :data="data.logs" style="width: 100%">
                <el-table-column
                    prop="webmaster_id"
                    label="站长ID"
                    min-width="80">
                </el-table-column>

                <el-table-column
                    prop="ip"
                    label="IP地址"
                    min-width="150">
                </el-table-column>

                <el-table-column
                    prop="region"
                    label="省份"
                    min-width="120">
                </el-table-column>

                <el-table-column
                    prop="city"
                    label="城市"
                    min-width="120">
                </el-table-column>

                <el-table-column
                    prop="isp"
                    label="网络"
                    min-width="120">
                </el-table-column>

                <el-table-column
                    prop="created_at"
                    label="时间"
                    fixed="right"
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
        
        this.group.page = '/admin/webmaster/loginlogs';

        this.getLoginlogs();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getLoginlogs: function()
        {
            var Th = this;
            
            Th.loading = true;

            Th.$api.get('admin/webmaster/loginlogs.json', Th.paramete, function(data)
            {
                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getLoginlogs();
        },
        //-------------------------------------列表分页-------------------------------------
    },
}
</script>