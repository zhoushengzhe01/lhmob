<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">广告充值</h3>
            <div class="search-box">
                <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">
                    <el-form-item>
                        <el-date-picker
                            value-format="yyyy-MM-dd"
                            type="date"
                            placeholder="选择日期"
                            v-model="paramete.date"
                            style="width: 100%;"
                        ></el-date-picker>
                    </el-form-item>

                    <el-form-item>
                        <el-input v-model="paramete.advertiser_id" placeholder="广告主ID"></el-input>
                    </el-form-item>
                    
                    <el-form-item>
                        <el-button type="primary" @click="getRecharges">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="box" v-loading="loading">

            <el-table :data="data.recharges" style="width: 100%">
                <el-table-column
                    prop="advertiser_id"
                    label="广告主ID"
                    min-width="80">
                </el-table-column>

                <el-table-column
                    prop="outname"
                    label="出款人"
                    min-width="80">
                </el-table-column>

                <el-table-column
                    prop="operator"
                    label="操作人"
                    min-width="80">
                </el-table-column>

                <el-table-column
                    prop="message"
                    label="说明"
                    min-width="250">
                </el-table-column>

                <el-table-column
                    label="金额"
                    min-width="100">
                    <template slot-scope="scope">
                        {{scope.row.money}} 元
                    </template>
                </el-table-column>

                <el-table-column
                    label="状态"
                    min-width="100">
                    <template slot-scope="scope">
                        <el-tag v-if="scope.row.state=='1'" type="info" size="small">等待申请</el-tag>
                        <el-tag v-if="scope.row.state=='2'" type="info" size="small">等待打款</el-tag>
                        <el-tag v-if="scope.row.state=='3'" type="warning" size="small">等待确认</el-tag>
                        <el-tag v-if="scope.row.state=='4'" type="success" size="small">充值完成</el-tag>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="created_at"
                    label="时间"
                    min-width="160">
                </el-table-column>

                <el-table-column
                    fixed="right"
                    label="操作"
                    width="80">
                    <template slot-scope="scope">
                        <el-button type="text" size="medium" @click="getRecharge(scope.row)">编辑</el-button>
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


        <!--弹窗编辑-->
        <el-dialog title="添加/编辑" :visible.sync="show" class="small_dialog">

             <el-form :model="recharge" label-width="80px" size="medium" v-loading="loadingItem">

                <el-form-item label="广告主ID">
                    <el-input v-model="recharge.advertiser_id" disabled></el-input>
                </el-form-item>

                <el-form-item label="充值金额">
                    <el-input v-model="recharge.money"><template slot="append">元</template></el-input>
                </el-form-item>

                <el-form-item label="出款人">
                    <el-input v-model="recharge.outname"></el-input>
                </el-form-item>

                <el-form-item label="操作人">
                    <el-input v-model="recharge.operator" disabled></el-input>
                </el-form-item>

                <el-form-item label="说明">
                    <el-input v-model="recharge.message"></el-input>
                </el-form-item>

                <el-form-item label="打款状态">
                    <el-select v-model="recharge.state" placeholder="请选择状态" style="width:100%">
                        <el-option label="等待申请" value="1"></el-option>
                        <el-option label="等待打款" value="2"></el-option>
                        <el-option label="等待确认" value="3"></el-option>
                        <el-option label="充值完成" value="4"></el-option>
                    </el-select>
                </el-form-item>

            </el-form>
            
            <div slot="footer" class="dialog-footer">
                <el-button @click="show = false">取 消</el-button>
                <el-button type="primary" @click="putRecharge(recharge)">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
export default {
    name: 'recharge',
    data: function () { 
        return {
            group: Group,
            
            loading: true,
            
            loadingItem: true,

            show: false,
            
            recharge: {},

            paramete: {
                offset: 0,
                limit: 15,
            },
            data: {},
        };
    },
    created: function () {
        this.group.page = 'recharge';
        this.getRecharges();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getRecharges: function()
        {
            var Th = this;

            Th.loading = true;
            
            Th.$api.get('admin/recharges.json', Th.paramete, function(data)
            {
                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        
        },
        pageChange: function(val) {
            
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);

            this.getRecharges();
        },
        //-------------------------------------列表分页-------------------------------------

        getRecharge: function(row)
        {
            var Th = this;

            Th.show = true;

            Th.recharge = row;

            Th.loadingItem = false;
        },

        putRecharge: function(row)
        {
            var Th = this;

            Th.loadingItem = true;

            Th.$api.put('admin/recharge/'+row.id+'.json', row, function(data)
            {
                Th.$emit('message', 'success', '编辑成功');

                Th.loadingItem = false;

                Th.show = false;

            }, function(type, message){ Th.loadingItem = false; Th.$emit('message', type, message); });
        },

    },

}
</script>