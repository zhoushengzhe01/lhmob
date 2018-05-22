<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">添加/编辑</h3>
        </div>

        <div class="box"  style="padding: 24px;">
            <el-form ref="form" :model="data.ad" label-width="80px" size="medium">
                
                <el-form-item label="广告标题">
                    <el-input v-model="data.ad.title"></el-input>
                </el-form-item>

                <el-form-item label="推广链接">
                    <el-input v-model="data.ad.link"></el-input>
                </el-form-item>

                <el-form-item label="广告主ID">
                    <el-input v-model="data.ad.advertiser_id"></el-input>
                </el-form-item>

                <el-row style="width:600px;">
                    <el-col :span="12">
                        <el-form-item label="广告类型">
                            <el-select v-model="data.ad.adstype_id" placeholder="选择类型" style="width:100%">
                                <el-option v-for="item in group.adsType" :label="item.label" :value="parseInt(item.value)"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="计费类型">
                            <el-select v-model="data.ad.price_type" placeholder="选择计费类型" style="width:100%">
                                <el-option label="点击" value="1"></el-option>
                                <el-option label="展示" value="2"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                

                <el-form-item label="选择素材">
                    <el-select v-model="data.ad.package_id" placeholder="选择类型" style="width:100%" @focus="getPackages">
                        <el-option v-for="item in packages" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>

                

                <el-form-item label="设置日期">
                    <el-date-picker
                        value-format="yyyy-MM-dd"
                        v-model="data.ad.date"
                        type="daterange"
                        range-separator="~"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期">
                    </el-date-picker>
                </el-form-item>

                <el-form-item label="统一权重">
                    <el-input-number v-model="data.ad.weight" :step="5" :min="1" :max="100"></el-input-number>
                </el-form-item>

                <el-row style="width:600px;">
                    <el-col :span="12">
                        <el-form-item label="一共消耗">
                            <el-input v-model="data.ad.expend" disabled><template slot="append">元</template></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="今日消耗">
                            <el-input v-model="data.ad.expend_day" disabled><template slot="append">元</template></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row style="width:600px;">
                    <el-col :span="12">
                        <el-form-item label="广告价格">
                            <el-input v-model="data.ad.in_price"><template slot="append">元</template></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="站长价格">
                            <el-input v-model="data.ad.out_price"><template slot="append">元</template></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row style="width:600px;">
                    <el-col :span="12">
                        <el-form-item label="广告预算">
                            <el-input v-model="data.ad.budget"><template slot="append">元</template></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="每日预算">
                            <el-input v-model="data.ad.budget_day"><template slot="append">元</template></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>


                <el-form-item label="投放系统">
                    <el-radio-group v-model="data.ad.client">
                        <el-radio label="0">全部</el-radio>
                        <el-radio label="1">IOS</el-radio>
                        <el-radio label="2">Android</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="是否微信">
                    <el-radio-group v-model="data.ad.is_wechat">
                        <el-radio label="0">WEB</el-radio>
                        <el-radio label="1">微信</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="小时权重">
                    <el-radio-group v-model="data.ad.is_hour_weight">
                        <el-radio label="0">全部</el-radio>
                        <el-radio label="1">设置</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-collapse-transition>
                <el-form-item label="小时权重" style="background: #f9f9f9; max-width: 100%;" v-if="data.ad.is_hour_weight=='1'">
                    <div class="hour_weight">
                        <div class="hour-item" v-for="(item, index) in group.hours">
                            <span class="hour">{{item}}</span>
                            <el-slider 
                                step="5" 
                                :show-input="true" 
                                style="margin-left: 0px;" 
                                input-size="mini" 
                                v-model="data.ad.hour_weight[index]" 
                                height="200px" :vertical="true">
                            </el-slider>
                        </div>
                    </div>
                </el-form-item>
                </el-collapse-transition>

                <el-form-item label="投放分类">
                    <el-radio-group v-model="data.ad.is_put_category">
                        <el-radio label="0">全部</el-radio>
                        <el-radio label="1">选择</el-radio>
                    </el-radio-group>
                </el-form-item>
                
                <el-collapse-transition>
                <el-form-item label="" style="background: #f9f9f9; max-width: 100%;" v-if="data.ad.is_put_category=='1'">
                    <el-checkbox-group v-model="data.ad.categorys">
                        <el-checkbox v-for="item in group.categorys" :label="item.id" style="margin: 0 20px 0 0;">{{item.name}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                </el-collapse-transition>

                

                <el-form-item label="投放时段">
                    <el-radio-group v-model="data.ad.is_put_hour">
                        <el-radio label="0">全部</el-radio>
                        <el-radio label="1">选择</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-collapse-transition>
                <el-form-item style="background: #f9f9f9; max-width: 100%;" v-if="data.ad.is_put_hour=='1'">
                    <el-checkbox-group v-model="data.ad.hours">
                        <el-checkbox v-for="hour in group.hours" :label="hour" :key="hour" style="margin: 0 20px 0 0;">{{hour}}时</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                </el-collapse-transition>

                <el-form-item label="状态">
                    <el-select v-model="data.ad.state" placeholder="请选择状态">
                        <el-option label="待审核" value="0"></el-option>
                        <el-option label="使用" value="1"></el-option>
                        <el-option label="停止" value="2"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="postAd(data.ad)">确定</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>
<script>
export default {
    name: 'ad',
    data: function () { 
        return {
            group: Group,
            loading: true,
            id: this.$route.params.id,
            packages: {},
            data: {
                ad: {

                }
            },
        };
    },
    created: function () {
    
        this.group.page = '/admin/advertiser/ads';

        if(this.id)
        {
            this.getAd();
        }
        else
        {
            this.data.ad = {
                adstype_id:11,
                price_type:'1',
                in_price:100,
                out_price:40,
                client:'0',
                is_wechat:'0',
                is_hour_weight:'0',
                is_put_category:'0',
                is_put_hour:'0',
                state:'1',
                weight: 80,
                budget: 0,
                budget_day: 0,
                hour_weight: []
            };
        }
        
    },
    methods:{
        getAd: function()
        {
            var Th = this;
            Th.loading = false;
            Th.$api.get('admin/advertiser/ad/'+Th.id+'.json', {}, function(data)
            {   
                Th.data = data;

                Th.loading = false;

                Th.getPackages();

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },

        getPackages: function()
        {
            var Th = this;

            if(Th.data.ad.adstype_id && Th.data.ad.advertiser_id)
            {
                var paramet = {
                
                    adstype_id: Th.data.ad.adstype_id,

                    advertiser_id: Th.data.ad.advertiser_id
                };

                Th.$api.get('admin/advertiser/packages.json', paramet, function(data)
                {
                    Th.packages = data.packages;

                }, function(type, message){ Th.$emit('message', type, message); });
            }
            else
            {
                Th.$emit('message', 'warning', '请先输入广告主ID 和 广告类型');

                Th.packages = {};
            }
        },

        postAd: function(row)
        {
            var Th = this;
            
            Th.loading = true;

            if(row.id)
            {
                Th.$api.put('admin/advertiser/ad/'+row.id+'.json', row, function(data)
                {
                    Th.loading = false;

                    Th.$emit('message', 'success', '修改成功');

                    Th.getAd();

                }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
            }
            else
            {
                Th.$api.post('admin/advertiser/ad.json', row, function(data)
                {
                    Th.loading = false;

                    Th.$emit('message', 'success', '添加成功');

                    Th.$router.push({path:'/admin/advertisers'});

                }, function(type, message){ Th.loading = false;  Th.$emit('message', type, message); });
            }
        },
    },
}
</script>