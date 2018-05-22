<template>
    <div class="content">
        <div class="title-box">
            <h3 class="title">添加素材</h3>
        </div>

        <div class="box" v-loading="loading" style="padding: 24px;">
            <el-form ref="form" :model="data.webmasterad" label-width="80px" size="medium" style="max-width: 600px;">
                
                <el-form-item label="广告名称">
                    <el-input v-model="data.webmasterad.name"></el-input>
                </el-form-item>

                <el-form-item label="广告类型">
                    <el-radio-group v-model="data.webmasterad.position_id">
                        <el-radio v-for="item in group.adsType" :label="parseInt(item.value)">{{item.label}}</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="广告位置" v-if="data.webmasterad.position_id=='11'">
                    <el-radio-group v-model="data.webmasterad.position">
                        <el-radio label="1">顶部</el-radio>
                        <el-radio label="2">底部</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="计费方式">
                    <el-radio-group v-model="data.webmasterad.billing">
                        <el-radio label="CPC"></el-radio>
                        <el-radio label="CPM"></el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="广告比例">
                    <el-slider show-input="true" v-model="data.webmasterad.ad_ratio"></el-slider>
                </el-form-item>

                <el-form-item label="联盟计费">
                    <el-input v-model="data.webmasterad.out_alliance_price"><template slot="append">%</template></el-input>
                </el-form-item>

                <el-row>
                    <el-col :span="12">
                        <el-form-item label="广告计费">
                            <el-input v-model="data.webmasterad.out_advertiser_price"><template slot="append">%</template></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="站长计费">
                            <el-input v-model="data.webmasterad.in_advertiser_price"><template slot="append">%</template></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item label="假关闭率">
                    <el-input v-model="data.webmasterad.false_close"><template slot="append">%</template></el-input>
                </el-form-item>

                <el-form-item label="暗层高度">
                    <el-input v-model="data.webmasterad.hid_height"><template slot="append">px</template></el-input>
                </el-form-item>

                <el-row>
                    <el-col :span="12">
                        <el-form-item label="是否检测">
                            <el-select v-model="data.webmasterad.is_check">
                                <el-option label="检测" value="1"></el-option>
                                <el-option label="停止" value="0"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="广告尺寸">
                            <el-select v-model="data.webmasterad.ad_size">
                                <el-option label="640*200" value="1"></el-option>
                                <el-option label="640*150" value="2"></el-option>
                                <el-option label="640*100" value="3"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :span="12">
                        <el-form-item label="状态">
                            <el-select v-model="data.webmasterad.state">
                                <el-option label="开启" value="1"></el-option>
                                <el-option label="停止" value="2"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="顶置">
                            <el-select v-model="data.webmasterad.is_top">
                                <el-option label="顶置" :value="1"></el-option>
                                <el-option label="排后" :value="0"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                

                <el-form-item>
                    <el-button type="primary" @click="putWebmasterad">确定</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </div>


    </div>
</template>
<script>
export default {
    name: 'webmasterad',
    data: function () { 
        return {
            group: Group,
            loading: true,
            id: this.$route.params.id,
            data: {
                webmasterad: {}
            },
        };
    },
    created: function () {
        
        this.group.page = '/admin/webmaster/ads';

        this.getWebmasterad();
    },
    methods:{
        getWebmasterad: function()
        {
            var Th = this;
            Th.loading = true;
            Th.$api.get('admin/webmaster/ad/'+Th.id+'.json', {}, function(data)
            {
                Th.data = data;
                
                Th.loading = false;

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },

        putWebmasterad: function()
        {
            var Th = this;
            
            Th.loading = true;
            
            Th.$api.put('admin/webmaster/ad/'+Th.id+'.json', Th.data.webmasterad, function(data)
            {
                Th.loading = false;

                Th.$emit('message', 'success', '修改成功');

                Th.$router.push({path:'/admin/webmaster/ads'});

            }, function(type, message){ Th.loading = false; Th.$emit('message', type, message); });
        },
    },
}
</script>