<template>   
<div class="content">
    <div class="title-box">
        <h3 class="title">我的广告</h3>
        <div class="search-box">
            <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">
                <el-form-item label="">
                    <el-input v-model="paramete.name" placeholder="名称"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="getMyads">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <router-link to="/webmaster/myad">
                        <el-button type="primary">创建广告</el-button>
                    </router-link>
                </el-form-item>
            </el-form>
        </div>
    </div>

    <div class="box" v-loading="loading">

        <el-table :data="data.myads" style="width: 100%">
            <el-table-column
                prop="id"
                label="广告id"
                min-width="120">
            </el-table-column>
            
            <el-table-column
                prop="name"
                label="广告名称"
                min-width="150">
            </el-table-column>

            <el-table-column
                prop="position_name"
                label="广告类型"
                min-width="150">
            </el-table-column>

            <el-table-column
                prop="billing"
                label="计费类型"
                min-width="150">
            </el-table-column>

            <el-table-column
                label="创建"
                prop="created_at"
                min-width="200">
            </el-table-column>

            <el-table-column
                v-bind:router="true"
                fixed="right"
                label="操作"
                width="120">
                <template slot-scope="scope">
                    
                    <el-button type="text" size="small" @click="getCode(scope.row)">获取代码</el-button>

                    <router-link :to="'/webmaster/myad/'+scope.row.id">
                    
                        <el-button type="text" size="small">编辑</el-button>
                    
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

    <!--获取代码-->
    <el-dialog title="获取代码" :visible.sync="show" width="600px">

        <el-form label-position="left" label-width="80px" :model="code" size="small" class="getcode">
            
            <el-form-item label="广告名称">
                <el-input v-model="code.name" disabled></el-input>
            </el-form-item>

            <el-form-item label="代码类型">
                <el-radio-group v-model="code.type">
                    <el-radio :label="1">HTML代码</el-radio>
                    <el-radio :label="2">JS 代码</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="请求协议">
                <el-radio-group v-model="code.http">
                    <el-radio label="http">HTTP 协议</el-radio>
                    <el-radio label="https">HTTPS 协议</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="广告代码">
                <textarea rows="3" cols="20" v-if="code.type==1"><script>;(function() { var body = document.getElementsByTagName('body')[0]; var script = document.createElement('script'); script.type = 'text/javascript'; script.src = "{{code.http}}://lh.cxmyq.com/hf/{{code.id}}?time=" + Math.random(); body.appendChild(script); })();</script></textarea>
                
                <textarea rows="3" cols="20" v-if="code.type==2">;(function() { var body = document.getElementsByTagName('body')[0]; var script = document.createElement('script'); script.type = 'text/javascript'; script.src = "{{code.http}}://lh.cxmyq.com/hf/{{code.id}}?time=" + Math.random(); body.appendChild(script); })();</textarea>

            </el-form-item>

        </el-form>

        <div slot="footer" class="dialog-footer">
            <el-button @click="show = false">关闭</el-button>
        </div>
    </el-dialog>


</div>
</template>

<script>
export default {
	name: 'user',
    data: function () {	
		return {
            group: Group,
            loading: true,
            show: false,
            paramete: {
                offset: 0,
                limit: 10,
            },
			data: {},
            myad: {},
            form: {},

            code: {
                type: 1,
                http: 'http'
            },
		};
	},
	created: function () {
        
        this.group.page = '/webmaster/myads';

        this.getMyads();
    },
    methods:{
        //-------------------------------------列表分页-------------------------------------
        getMyads: function() {
            
            var Th = this;
            
            Th.loading = true;

            Th.$api.get('webmaster/myads.json', Th.paramete, function(data){
                
                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getMyads();
        },
        //-------------------列表分页-------------------------------------


        getCode: function(row)
        {
            var Th = this;

            Th.code.id = row.id;
            Th.code.name = row.name;

            Th.show = true;
        },

	},
}
</script>