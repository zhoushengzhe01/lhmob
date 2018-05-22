<template>
<div class="content">
    <div class="title-box">
        <h3 class="title">我的广告</h3>
        <div class="search-box">
            <el-form :inline="true" :model="paramete" class="demo-form-inline" size="mini">
                <el-form-item>
                    <el-input v-model="paramete.title" placeholder="标题"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="paramete.adsType" placeholder="类型">
                        <el-option
                            v-for="item in group.adsType"
                            :label="item.label"
                            :value="item.value"
                            :disabled="item.disabled">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="getAds">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <router-link to="/advertiser/ad">
                        <el-button type="primary"> + 添加广告</el-button>
                    </router-link>
                </el-form-item>
            </el-form>
        </div>
    </div>



    <div class="box" v-loading="loading">
        <el-table :data="data.ads" style="width: 100%">
            <el-table-column
                prop="title"
                label="标题"
                min-width="200">
            </el-table-column>

            <el-table-column
                prop="adstype_id"
                label="类型"
                min-width="100">
                <template slot-scope="scope">
                    <span v-for="type in group.adsType" v-if="type.value==scope.row.adstype_id">{{type.label}}</span>
                </template>
            </el-table-column>

            <el-table-column
                prop="price_type"
                label="计费方式"
                min-width="100">
                <template slot-scope="scope">
                    <span v-if="scope.row.price_type=='1'">CPC</span>
                    <span v-if="scope.row.price_type=='2'">CPM</span>
                </template>
            </el-table-column>

            <el-table-column
                prop=""
                label="投放设备"
                min-width="100">
                <template slot-scope="scope">
                    <span v-if="scope.row.client=='0'" class="info">全部</span>
                    <span v-if="scope.row.client=='1'" class="success">IOS</span>
                    <span v-if="scope.row.client=='2'" class="success">Android</span>
                </template>
            </el-table-column>

            <el-table-column
                label="限时广告"
                min-width="100">
                <template slot-scope="scope">
                    <span v-if="scope.row.is_put_hour=='1'" class="success">限时</span>
                    <span v-if="scope.row.is_put_hour=='0'" class="info">不限</span>
                </template>
            </el-table-column>
            
            <el-table-column
                label="预算/天"
                min-width="120">
                <template slot-scope="scope">
                    {{scope.row.budget_day}} 元
                </template>
            </el-table-column>
          
            <el-table-column
                label="总预算"
                min-width="120">
                <template slot-scope="scope">
                    {{scope.row.budget}} 元
                </template>
            </el-table-column>
            
            <el-table-column
                label="状态"
                min-width="80">
                <template slot-scope="scope">
                    <span v-if="scope.row.state=='0'" class="error">审核中</span>
                    <span v-if="scope.row.state=='1'" class="success">开启</span>
                    <span v-if="scope.row.state=='2'" class="info">停止</span>
                </template>
            </el-table-column>
            
            <el-table-column
                label="时间"
                prop="created_at"
                min-width="160">
            </el-table-column>

            <el-table-column
                v-bind:router="true"
                fixed="right"
                label="操作"
                width="100">
                <template slot-scope="scope">
                    <router-link :to="'/advertiser/ad/'+scope.row.id">
                        <el-button type="text" size="small">编辑</el-button>
                    </router-link>
                    <router-link to="/advertiser/package">
                        <el-button type="text" size="small">查看</el-button>
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
	name: 'user',
    data: function () {	
		return {
            group: Group,
            loading: true,
            paramete: {
                offset: 0,
                limit: 10,
            },
            data: {},  
		};
	},
	created: function () {
        
        this.group.page = '/advertiser/ads';

		this.getAds();
    },
    methods:{
		getAds: function() {
            
            var Th = this;
            
            Th.loading = true;

            Th.$api.get('advertiser/ads.json', Th.paramete, function(data){

                Th.data = data;

                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
        pageChange: function(val) {
            this.paramete.offset = parseInt(val-1) * parseInt(this.paramete.limit);
            this.getAds();
        },
	},
}
</script>