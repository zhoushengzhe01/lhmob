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
                        <el-input v-model="paramete.username" placeholder="会员名"></el-input>
                    </el-form-item>
                    
                    <!-- <el-form-item>
                        <el-input v-model="paramete.nickname" placeholder="真是姓名"></el-input>
                    </el-form-item> -->
                    
                    <el-form-item>
                        <el-input v-model="paramete.mobile" placeholder="手机号码"></el-input>
                    </el-form-item>
                    
                    <el-form-item>
                        <el-input v-model="paramete.qq" placeholder="QQ号码"></el-input>
                    </el-form-item>
                    
                    <el-form-item>
                        <el-button type="primary" @click="getWebmasters">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="box" v-loading="loading">

            <el-table :data="data.webmasters" style="width: 100%">
                <el-table-column
                    prop="id"
                    label="ID"
                    min-width="60">
                </el-table-column>

                <el-table-column
                    prop="username"
                    label="用户名"
                    min-width="200">
                </el-table-column>

                <el-table-column
                    prop="nickname"
                    label="真实姓名"
                    min-width="120">
                </el-table-column>

                <el-table-column
                    prop="qq"
                    label="QQ号码"
                    min-width="120">
                </el-table-column>

                <el-table-column
                    label="结算"
                    min-width="100">
                    <template slot-scope="scope">
                        <span v-if="scope.row.withdrawals_type=='1'">日结</span>
                        <span v-if="scope.row.withdrawals_type=='2'">周结</span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="余额"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.money}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    label="状态"
                    min-width="100">
                    <template slot-scope="scope">
                        <el-tag v-if="scope.row.state=='1'" type="success" size="small">正常</el-tag>
                        <el-tag v-if="scope.row.state=='2'" type="info" size="small">被封</el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="created_at"
                    label="时间"
                    min-width="200">
                </el-table-column>

                <el-table-column
                    v-bind:router="true"
                    fixed="right"
                    label="操作"
                    width="160">
                    <template slot-scope="scope">
                        <router-link :to="'/admin/webmaster/'+scope.row.id">
                            <el-button type="text" size="medium">编辑</el-button>
                        </router-link>

                        <router-link :to="'/admin/webmaster/websites?webmaster_id='+scope.row.id">
                            <el-button type="text" size="medium">网站</el-button>
                        </router-link>

                        <router-link :to="'/admin/webmaster/ads?webmaster_id='+scope.row.id">
                            <el-button type="text" size="medium">广告</el-button>
                        </router-link>

                        <router-link :to="'/admin/webmaster/takemoneys?webmaster_id='+scope.row.id">
                            <el-button type="text" size="medium">提现</el-button>
                        </router-link>

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
        
        this.group.page = '/admin/webmasters';

        this.getWebmasters();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getWebmasters: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/webmasters.json', Th.paramete, function(data)
            {
                Th.data = data;
                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getWebmasters();
        },
        //-------------------------------------列表分页-------------------------------------
    },
}
</script>