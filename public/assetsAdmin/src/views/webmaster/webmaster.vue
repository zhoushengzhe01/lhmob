<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">站长编辑</h3>
            <div class="search-box">
                <el-button type="primary" @click="getbank" size="mini">收款账户</el-button>
            </div>
        </div>

        <div class="box" v-loading="loading" style="padding: 24px;">
            <el-form ref="form" :model="data.webmaster" label-width="80px" size="medium" style="max-width: 580px;">
                
                <el-form-item label="登录名称">
                    <el-input v-model="data.webmaster.username" disabled></el-input>
                </el-form-item>
                
                <el-form-item label="账户余额">
                    <el-input v-model="data.webmaster.money"><template slot="append">元</template></el-input>
                </el-form-item>

                <el-form-item label="真实姓名">
                    <el-input v-model="data.webmaster.nickname"></el-input>
                </el-form-item>

                <el-form-item label="登录密码">
                    <el-input type="password" v-model="data.webmaster.password" placeholder="不填写则不修改"></el-input>
                </el-form-item>

                <el-form-item label="电子邮箱">
                    <el-input v-model="data.webmaster.email"></el-input>
                </el-form-item>

                <el-form-item label="手机号码">
                    <el-input v-model="data.webmaster.mobile"></el-input>
                </el-form-item>

                <el-form-item label="QQ 号码">
                    <el-input v-model="data.webmaster.qq"></el-input>
                </el-form-item>

                <el-form-item label="允许联盟">
                    <el-checkbox-group v-model="data.webmaster.allow_alliance">
                        <el-checkbox v-for="item in group.alliances" :label="item.id">{{item.name}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>

                <el-form-item label="禁止联盟">
                    <el-checkbox-group v-model="data.webmaster.disabled_alliance">
                        <el-checkbox v-for="item in group.alliances" :label="item.id">{{item.name}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="客服">
                            <el-select v-model="data.webmaster.service_id" placeholder="选择所属客服">
                                <el-option v-for="item in users" :label="item.nickname" :value="item.id"></el-option>
                            </el-select> 
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="结算">
                            <el-select v-model="data.webmaster.withdrawals_type" placeholder="选择所属客服">
                                <el-option label="日结" value="1"></el-option>
                                <el-option label="周结" value="2"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="域名">
                            <el-select v-model="data.webmaster.is_limit_domain" placeholder="选择所属客服">
                                <el-option label="限制" value="1"></el-option>
                                <el-option label="不限" value="2"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                

                <el-form-item label="状态">
                    <el-switch
                        active-value="1"
                        inactive-value="2"
                        v-model="data.webmaster.state">
                    </el-switch>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="putWebmaster">确定</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </div>

        <div class="title-box">
            <h3 class="title">备注列表</h3>
            <div class="search-box">
                <el-button type="primary" @click="noteshow = true" size="mini">添加备注</el-button>
            </div>
        </div>
        <div class="box" v-loading="noteloading">

            <el-table :data="notedata.notes" style="width: 100%">

                <el-table-column
                    prop="username"
                    label="备注人"
                    min-width="100">
                </el-table-column>

                <el-table-column
                    prop="note"
                    label="备注内容"
                    min-width="500">
                </el-table-column>
            
                <el-table-column
                    prop="created_at"
                    label="时间"
                    min-width="180">
                </el-table-column>

            </el-table>

            <div class="page-box">
                <el-pagination
                @current-change="pageChange"
                layout="total, prev, pager, next"
                :page-size="noteparamete.limit"
                :total="notedata.count">
                </el-pagination>
            </div>
        </div>



        <!--添加备注-->
        <el-dialog title="添加备注" :visible.sync="noteshow" class="mini_dialog">
            <el-form ref="form" label-position="top" :model="noteitem" label-width="80px" size="small" v-loading="noteloading">
                <el-form-item label="">
                    <el-input type="textarea" :rows="6" v-model="noteitem.note"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="noteshow = false" size="small">取 消</el-button>
                <el-button type="primary" @click="postNode" size="small">确 定</el-button>
            </div>
        </el-dialog>


        <!--修改收款账户-->
        <el-dialog title="收款账户" :visible.sync="bankshow" class="mini_dialog">
            
            <el-form ref="form" :model="data.bank" label-width="80px" size="medium" style="max-width: 500px;" v-loading="bankloading">

                <el-form-item label="收款银行" prop="region">
                    <el-select v-model="bank.bankname" placeholder="请选择银行" style="width:100%">
                        <el-option v-for="item in banks" :label="item.name" :value="item.name"></el-option>
                    </el-select>
                </el-form-item>
                
                <el-form-item label="开户行">
                    <el-input v-model="bank.branch"></el-input>
                </el-form-item>
                
                <el-form-item label="银行账号">
                    <el-input v-model="bank.accountid"></el-input>
                </el-form-item>
                
                <el-form-item label="开户姓名">
                    <el-input v-model="bank.account"></el-input>
                </el-form-item>

            </el-form>

            <div slot="footer" class="dialog-footer">
                <el-button @click="bankshow = false" size="small">取 消</el-button>
                <el-button type="primary" @click="putbank" size="small">确 定</el-button>
            </div>
        </el-dialog>


    </div>
</template>
<script>
export default {
    name: 'webmaster',
    data: function () { 
        return {
            group: Group,
            loading: true,
            id: this.$route.params.id,
            users: {},
            data: {
                webmaster: {}
            },

            noteloading: false,
            noteparamete: {
                offset: 0,
                limit: 10,
            },
            notedata: {},
            noteitem: {},
            noteshow: false,


            bank: {},
            banks: {},
            bankshow: false,
            bankloading: false,

        };
    },
    created: function () {
        
        this.group.page = '/admin/webmasters';

        this.getWebmaster();
        
        this.getUsers();

        this.getNodes();
    },
    methods:{
        getWebmaster: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/webmaster/'+Th.id+'.json', {}, function(data)
            {
                Th.data = data;
                
                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },

        getUsers: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/users.json', {department_id: 3}, function(data)
            {
                Th.users = data.users;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },

        //-------------------------------备注列表-------------------------------
        getNodes: function()
        {
            var Th = this;
            Th.noteloading = true;
            Th.$api.get('admin/webmaster/notes/'+Th.id+'.json', Th.noteparamete, function(data)
            {
                Th.notedata = data;

                Th.noteloading = false;

            }, function(type, message){ Th.noteloading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.noteparamete.offset = parseInt(val-1) * parseInt(this.noteparamete.limit);
            this.getNodes();
        },
        postNode: function()
        {
            var Th = this;

            Th.$api.post('admin/webmaster/note/'+Th.id+'.json', Th.noteitem, function(data)
            {
                Th.$emit('message', 'success', '备注成功');

                Th.getNodes();

                Th.noteshow = false;

            }, function(type, message){ Th.noteshow = false; Th.$emit('message', type, message); });
        },
        //-------------------------------备注列表-------------------------------




        //-------------------------------收款账户-------------------------------

        getbanks: function()
        {
            var Th = this;
            
            Th.bankshow = true;

            Th.$api.get('admin/banks.json', {}, function(data)
            {
                Th.banks = data.banks;

            }, function(type, message){ Th.$emit('message', type, message); });
        },

        getbank: function()
        {
            var Th = this;
            
            Th.bankloading = true;

            Th.getbanks();

            Th.$api.get('admin/webmaster/bank/'+Th.id+'.json', {}, function(data)
            {
                if(data.bank)
                {
                    Th.bank = data.bank;
                }
                
                Th.bankloading = false;

            }, function(type, message){ Th.bankloading = false; Th.$emit('message', type, message); });
        },
        putbank: function()
        {
            var Th = this;

            Th.$api.put('admin/webmaster/bank/'+Th.id+'.json', Th.bank, function(data)
            {
                Th.$emit('message', 'success', '修改成功');

            }, function(type, message){ Th.$emit('message', type, message); });
        },

        //-------------------------------收款账户-------------------------------


        putWebmaster: function()
        {
            var Th = this;
            
            Th.loading = true;
            
            Th.$api.put('admin/webmaster/'+Th.id+'.json', Th.data.webmaster, function(data)
            {
                Th.loading = false;

                Th.$emit('message', 'success', '修改成功');

                Th.$router.push({path:'/admin/webmasters'});

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
    },
}
</script>