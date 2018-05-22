<template>
<div class="content">
    <div class="title-box">
        <h3 class="title">创建编辑</h3>
    </div>

    <div class="box" v-loading="loading" style="padding: 24px;">
        <el-form ref="form" :model="data.package" label-width="80px" size="medium" style="max-width: 500px;">
            <el-form-item label="广告名称">
                <el-input v-model="data.myad.name"></el-input>
            </el-form-item>

            <el-form-item label="广告类型">
                <el-radio-group v-model="data.myad.position_id">
                    <el-radio
                        v-for="item in group.adsType" 
                        :label="parseInt(item.value)"
                        :disabled="item.disabled"
                    >{{item.label}}</el-radio>
                </el-radio-group>
            </el-form-item>


            <el-form-item label="广告位置">
                <el-radio-group v-model="data.myad.position">
                    <el-radio label="2">底浮</el-radio>
                    <el-radio label="1">顶浮</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="计费方式">
                <el-radio-group v-model="data.myad.billing">
                    <el-radio label="CPC">CPC</el-radio>
                    <el-radio label="CPM">CPV</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="postMyad">确定</el-button>
                <el-button>取消</el-button>
            </el-form-item>
        </el-form>
    </div>


</div>
</template>

<script>
export default {
	name: 'package',
    data: function () {	
		return {
            group: Group,
            loading: true,
            id: this.$route.params.id,
			data: {
                myad: {
                    name: '',
                    position_id: 11,
                    position: '2',
                    billing: 'CPC',
                },
            },
		};
    },
	created: function () {
        
        this.group.page = '/webmaster/myads';

        if(this.id)
        {
            this.getMyad();
        }else
        {
            this.loading = false;
        }
    },
    methods:{
        //------------------------------------数据获取和修改---------------------------------
        getMyad: function()
        {
            var Th = this;

            Th.loading = true;

            Th.$api.get('webmaster/myad/'+Th.id+'.json' ,[] , function(data){
            
                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        postMyad: function()
        {
            var Th = this;
            
            Th.loading = true;

            if(this.id)
            {
                Th.$api.put('webmaster/myad/'+Th.id+'.json', Th.data.myad, function(data){

                    Th.$emit('message', 'success', '修改成功');

                    Th.$router.push({path:'/webmaster/myads'});

                    Th.loading = false;

                }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
            }
            else
            {
                Th.$api.post('webmaster/myad.json', Th.data.myad, function(data){

                    Th.$emit('message', 'success', '添加成功');

                    Th.$router.push({path:'/webmaster/myads'});

                    Th.loading = false;

                }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
                
            }
        },
        //------------------------------------数据获取和修改---------------------------------
	},
}
</script>