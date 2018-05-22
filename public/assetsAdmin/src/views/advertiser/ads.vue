<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">广告管理</h3>
            <div class="search-box">
                <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">
                    <el-form-item>
                        <el-input v-model="paramete.webmaster_id" placeholder="广告主ID"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-select v-model="paramete.adstype_id" placeholder="选择类型" style="width:100%">
                            <el-option v-for="item in group.adsType" :label="item.label" :value="item.value"></el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item>
                        <el-input v-model="paramete.title" placeholder="广告标题"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="getAds">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="box" v-loading="loading">

            <el-table :data="data.ads" style="width: 100%">
                <el-table-column
                    prop="advertiser_id"
                    label="ID"
                    min-width="60">
                </el-table-column>

                <el-table-column
                    prop="title"
                    label="标题"
                    min-width="150">
                    <template slot-scope="scope">
                        <el-tooltip placement="right" effect="light">
                            <div slot="content">
                                每日预算：{{scope.row.budget_day}} 元<br/>
                                总预算：{{scope.row.budget}} 元
                            </div>
                            <el-button type="text" size="medium">{{scope.row.title}}</el-button>
                        </el-tooltip>
                    </template>
                </el-table-column>

                <el-table-column
                    label="类型"
                    min-width="80">
                    <template slot-scope="scope">
                        <span v-for="item in group.adsType" v-if="item.value==scope.row.adstype_id">{{item.label}}</span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="价格"
                    min-width="100">
                    <template slot-scope="scope">
                    {{scope.row.out_price}} 元<br/>{{scope.row.in_price}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    label="是否限时"
                    min-width="100">
                    <template slot-scope="scope">
                        <el-tag v-if="scope.row.is_put_hour=='0'" type="success" size="small">不限</el-tag>
                        <el-tag v-if="scope.row.is_put_hour=='1'" type="warning" size="small">限时</el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    label="是否限站"
                    min-width="100">
                    <template slot-scope="scope">
                        <el-tag v-if="scope.row.is_put_webmaster=='0'" type="success" size="small">不限</el-tag>
                        <el-tag v-if="scope.row.is_put_webmaster=='1'" type="warning" size="small">限站</el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    label="权重"
                    min-width="100">
                    <template slot-scope="scope">
                        <span v-if="scope.row.is_hour_weight=='0'">{{scope.row.weight}}</span>
                        <span v-if="scope.row.is_hour_weight=='1'">时段</span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="是否微信"
                    min-width="100">
                    <template slot-scope="scope">
                        <span v-if="scope.row.is_wechat=='0'">微信</span>
                        <span v-if="scope.row.is_wechat=='1'">WEB</span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="投放时间"
                    min-width="120">
                    <template slot-scope="scope">
                        <span v-if="scope.row.put_date_start">
                        {{scope.row.put_date_start}}<br/>
                        {{scope.row.put_date_stop}}
                        </span>
                        <span v-if="!scope.row.put_date_start" style="color:#ccc">无限制</span>
                    </template>
                </el-table-column>

                <el-table-column
                    label="消耗"
                    min-width="120">
                    <template slot-scope="scope">
                        {{scope.row.expend_day}} 元<br/>
                        {{scope.row.expend}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    label="状态"
                    min-width="100">
                    <template slot-scope="scope">
                        <el-tag v-if="scope.row.state=='1'" type="success" size="small">正常</el-tag>
                        <el-tag v-if="scope.row.state=='2'" type="success" size="small">关闭</el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    v-bind:router="true"
                    fixed="right"
                    label="操作"
                    width="60">
                    <template slot-scope="scope">
                        <el-button type="text" size="medium" @click="$router.push({path:'/admin/advertiser/ad/'+scope.row.id})">编辑</el-button>
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
        
        this.group.page = window.location.pathname;

        this.getAds();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getAds: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/advertiser/ads.json', Th.paramete, function(data)
            {
                Th.data = data;
                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getAds();
        },
        //-------------------------------------列表分页-------------------------------------

    },
}
</script>