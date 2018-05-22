<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">站长广告</h3>
            <div class="search-box">
                <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">

                    <el-form-item>
                        <el-input v-model="paramete.name" placeholder="广告名称"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-input v-model="paramete.webmaster_id" placeholder="站长ID"></el-input>
                    </el-form-item>
                    
                    <el-form-item>
                        <el-button type="primary" @click="getWebmasterads">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="box" v-loading="loading">

            <el-table :data="data.ads" style="width: 100%">
                <el-table-column
                    fixed="left"
                    prop="webmaster_id"
                    label="站长ID"
                    min-width="68">
                </el-table-column>

                <el-table-column
                    label="站长名字"
                    min-width="160">
                    <template slot-scope="scope">
                        <el-button type="text" size="medium">{{scope.row.username}}</el-button>
                    </template>
                </el-table-column>

                <el-table-column
                    label="广告类型"
                    min-width="120">
                    <template slot-scope="scope">
                        {{scope.row.position_name}}&nbsp;
                        {{scope.row.billing}}
                    </template>
                </el-table-column>

                <el-table-column
                    prop="price"
                    label="计费率"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    label="前天"
                    min-width="200">
                    <template slot-scope="scope">
                        <span v-if="scope.row.day[0]">
                        点:{{scope.row.day[0].click}}&nbsp;&nbsp;展:{{scope.row.day[0].pv}}
                        <br/>
                        {{scope.row.day[0].money}} 元
                        </span>
                        <span v-if="!scope.row.day[0]" style="color:#ccc">
                            无数据
                        </span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="昨天"
                    min-width="200">
                    <template slot-scope="scope">
                        <span v-if="scope.row.day[1]">
                        点:{{scope.row.day[1].click}}&nbsp;&nbsp;展:{{scope.row.day[1].pv}}
                        <br/>
                        {{scope.row.day[1].money}} 元
                        </span>
                        <span v-if="!scope.row.day[1]" style="color:#ccc">
                            无数据
                        </span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="今天"
                    min-width="200">
                    <template slot-scope="scope">
                        <span v-if="scope.row.day[2]">
                        点:{{scope.row.day[2].click}}&nbsp;&nbsp;展:{{scope.row.day[2].pv}}
                        <br/>
                        {{scope.row.day[2].money}} 元
                        </span>
                        <span v-if="!scope.row.day[2]" style="color:#ccc">
                            无数据
                        </span>
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
                    fixed="right"
                    label="操作"
                    width="150">
                    <template slot-scope="scope">
                        <el-button type="text" size="medium" @click="$router.push({path:'/admin/webmaster/ad/'+scope.row.id})">编辑</el-button>
                        <el-button type="text" size="medium" @click="$router.push({path:'/admin/webmaster/earningday/'+scope.row.id})">数据</el-button>
                        <el-button type="text" size="medium" @click="$router.push({path:'/admin/webmaster/earningclick/'+scope.row.id})">点击</el-button>
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
                webmaster_id: this.$api.getQueryString('webmaster_id'),
            },
            data: {},
        };
    },
    created: function () {
        
        this.group.page = '/admin/webmaster/ads';

        this.getWebmasterads();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getWebmasterads: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/webmaster/ads.json', Th.paramete, function(data)
            {
                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getWebmasterads();
        },
        //-------------------------------------列表分页-------------------------------------

    },
}
</script>