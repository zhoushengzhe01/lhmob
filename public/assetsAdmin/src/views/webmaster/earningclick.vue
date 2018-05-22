
<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">点击数据</h3>
        </div>

        <div class="box" v-loading="loading">

            <el-table :data="data.clicks" style="width: 100%">
                <el-table-column
                    prop="webmaster_id"
                    label="站长ID"
                    min-width="60">
                </el-table-column>

                <el-table-column
                    prop="name"
                    label="系统/IP"
                    min-width="140">
                    <template slot-scope="scope">
                        {{scope.row.system}}<br/>{{scope.row.ip}}
                    </template>
                </el-table-column>

                <el-table-column
                    prop="domain"
                    label="来源"
                    min-width="250">
                    <template slot-scope="scope">
                        {{scope.row.source}}
                    </template>
                </el-table-column>

                <el-table-column
                    label="地址"
                    min-width="250">
                    <template slot-scope="scope">
                        {{scope.row.url}}
                    </template>
                </el-table-column>

                <el-table-column
                    label="间隔/其他"
                    min-width="150">
                    <template slot-scope="scope">
                        {{scope.row.time}}<br/>{{scope.row.refso}}
                    </template>
                </el-table-column>

                <el-table-column
                    label="屏幕/点击位置"
                    min-width="120">
                    <template slot-scope="scope">
                        屏幕：{{scope.row.screen}}<br/>位置：{{scope.row.clickp}}
                    </template>
                </el-table-column>

                <el-table-column
                    prop="created_at"
                    label="时间"
                    min-width="100">
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
            webmaster_ad_id: this.$route.params.webmaster_ad_id,
            paramete: {
                offset: 0,
                limit: 30,
            },
            data: {},
        };
    },
    created: function () {
        
        this.group.page = '/admin/webmaster/ads';

        this.getEarningClick();
    },
    methods:{

        getEarningClick: function()
        {
            var Th = this;
            
            Th.loading = true;
            
            Th.$api.get('admin/webmaster/earning/click/'+Th.webmaster_ad_id+'.json', Th.paramete, function(data)
            {
                Th.data = data;
                
                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getEarningClick();
        },
    },
}
</script>