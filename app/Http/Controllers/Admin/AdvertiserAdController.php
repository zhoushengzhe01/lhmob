<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\AdvertiserAds;

use Hash;

class AdvertiserAdController extends ApiController
{

    public function getAdvertiserads(Request $request)
    {
        self::Admin();

        //网站杜索
        $advertiser_id = trim($request->input('advertiser_id'));
        $adstype_id = trim($request->input('adstype_id'));
        $title = trim($request->input('title'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $ads = AdvertiserAds::where('id', '<>', '0');

        if(!empty($advertiser_id))
            $ads = $ads->where('advertiser_id', '=', $advertiser_id);

        if(!empty($adstype_id))
            $ads = $ads->where('adstype_id', '=', $adstype_id);

        if(!empty($title))
            $ads = $ads->where('title', 'like', '%'.$title.'%');

        $count = $ads->count();
        $ads = $ads->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'ads'=>$ads,
        ];
        
        return response()->json(['data'=>$data], 200);
    }

    public function getAdvertiserad(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);        

        $ad = AdvertiserAds::where('id', '=', $id)->first();
        
        if(empty($ad))
            return response()->json(['message'=>'未找到数据'], 300);


        if(!empty($ad->hour_weight))
            $ad->hour_weight = json_decode($ad->hour_weight, true);
        else
            $ad->hour_weight = [];

        if(!empty($ad->webmasters))
            $ad->webmasters = json_decode($ad->webmasters, true);
        else
            $ad->webmasters = [];

        if(!empty($ad->categorys))
            $ad->categorys = json_decode($ad->categorys, true);
        else
            $ad->categorys = [];
        
        if(!empty($ad->hours))
            $ad->hours = json_decode($ad->hours, true);
        else
            $ad->hours = [];
        
        return response()->json(['data'=>['ad'=>$ad]], 200);    
    }

    public function putAdvertiserad(Request $request, $id)
    {
        self::Admin();
        
        if(empty($id))
        {
            return response()->json(['message'=>'缺少参数'], 400);
        }

        $present = $request->input();

        $ad = AdvertiserAds::where('id', '=', $id)->first();

        if(!empty($present['title'])){ $ad->title = trim($present['title']); }

        if(!empty($present['link'])){ $ad->link = trim($present['link']); }

        if(!empty($present['advertiser_id'])){ $ad->advertiser_id = trim($present['advertiser_id']); }

        if(!empty($present['adstype_id'])){ $ad->adstype_id = trim($present['adstype_id']); }

        if(!empty($present['package_id'])){ $ad->package_id = trim($present['package_id']); }

        if(!empty($present['price_type'])){ $ad->price_type = trim($present['price_type']); }

        if(!empty($present['out_price'])){ $ad->out_price = trim($present['out_price']); }

        if(!empty($present['in_price'])){ $ad->in_price = trim($present['in_price']); }

        if(!empty($present['weight'])){ $ad->weight = trim($present['weight']); }

        if(!empty($present['client']) || $present['client']=='0'){ $ad->client = trim($present['client']); }

        if(!empty($present['is_wechat']) || $present['is_wechat']=='0'){ $ad->is_wechat = trim($present['is_wechat']); }

        if(!empty($present['is_hour_weight']) || $present['is_hour_weight']=='0'){ $ad->is_hour_weight = trim($present['is_hour_weight']); }

        if(!empty($present['is_put_hour']) || $present['is_put_hour']=='0'){ $ad->is_put_hour = trim($present['is_put_hour']); }

        if(!empty($present['is_put_category']) || $present['is_put_category']=='0'){ $ad->is_put_category = trim($present['is_put_category']); }

        if(!empty($present['state']) || $present['state']=='0'){ $ad->state = trim($present['state']); }

        if($present['is_hour_weight']=='1')
        {
            if(count($present['hour_weight'])<12)
            {
                return response()->json(['message'=>'至少设置12个小时的权重'], 300);
            }else
            {
                $ad->hour_weight = json_encode($present['hour_weight'], true);
            }
        }

        if($present['is_put_category']=='1')
        {
            if(count($present['categorys'])<3)
            {
                return response()->json(['message'=>'至少选择三个投放分类'], 300);
            }else
            {
                $ad->categorys = json_encode($present['categorys'], true);
            }
        }

        if($present['is_put_hour']=='1')
        {
            if(count($present['hours'])<12)
            {
                return response()->json(['message'=>'至少选择投12个小时时段'], 300);
            }else
            {
                $ad->hours = json_encode($present['hours'], true);
            }
        }

        if(!empty($present['date']) && count($present['date'])==2)
        {
            $ad->put_date_start = $present['date'][0];
            $ad->put_date_stop = $present['date'][1];
        }
        else
        {
            $ad->put_date_start = '';
            $ad->put_date_stop = '';
        }
        
        if($ad->save())
        {
            return response()->json(['message'=>'添加成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'添加失败'], 300);
        }
    }

    public function postAdvertiserad(Request $request)
    {
        self::Admin();


        $present = $request->input();

        if(empty($present['title']))
            return response()->json(['message'=>'请输入广告标题'], 300);
        
        if(empty($present['link']))
            return response()->json(['message'=>'请输入推广地址'], 300);
        
        if(empty($present['advertiser_id']) && $present['advertiser_id']!='0')
            return response()->json(['message'=>'请输入广告主ID'], 300);
        
        if(empty($present['adstype_id']))
            return response()->json(['message'=>'请选择广告类型'], 300);
        
        if(empty($present['package_id']))
            return response()->json(['message'=>'请选择广告素材包'], 300);
        
        if(empty($present['price_type']))
            return response()->json(['message'=>'请选择计费方式'], 300);
        
        if(empty($present['out_price']))
            return response()->json(['message'=>'请输入站长价格'], 300);

        if(empty($present['in_price']))
            return response()->json(['message'=>'请输入点击价格'], 300);
        
        if(empty($present['weight']))
            return response()->json(['message'=>'请输入广告权重'], 300);

        if(empty($present['client']) && $present['client']!='0')
            return response()->json(['message'=>'选择投放系统'], 300);
        
        if(empty($present['is_wechat']) && $present['is_wechat']!='0')
            return response()->json(['message'=>'选择是否微信量'], 300);
        
        if($present['is_hour_weight']=='1')
        {
            if(count($present['hour_weight'])<12)
            {
                return response()->json(['message'=>'至少设置12个小时的权重'], 300);
            }else
            {
                $present['hour_weight'] = json_encode($present['hour_weight'], true);
            }
        }

        if($present['is_put_category']=='1')
        {
            if(count($present['categorys'])<3)
            {
                return response()->json(['message'=>'至少选择三个投放分类'], 300);
            }else
            {
                $present['categorys'] = json_encode($present['categorys'], true);
            }
        }

        if($present['is_put_hour']=='1')
        {
            if(count($present['hours'])<12)
            {
                return response()->json(['message'=>'至少选择投12个小时时段'], 300);
            }else
            {
                $present['hours'] = json_encode($present['hours'], true);
            }
        }
        
        if(!empty($present['date']) && count($present['date'])==2)
        {
            $put_date_start = $present['date'][0];
            $put_date_stop = $present['date'][1];
        }
        else
        {
            $put_date_start = '';
            $put_date_stop = '';
        }

        $ad = new AdvertiserAds;
        $ad->advertiser_id = trim($present['advertiser_id']);
        $ad->adstype_id = intval($present['adstype_id']);
        $ad->package_id = intval($present['package_id']);
        $ad->title = trim($present['title']);
        $ad->link = trim($present['link']);
        $ad->out_price = $present['out_price'];
        $ad->in_price = $present['in_price'];
        $ad->price_type = trim($present['price_type']);
        $ad->budget = trim($present['budget']);
        $ad->budget_day = trim($present['budget_day']);
        $ad->client = trim($present['client']);
        $ad->is_wechat = trim($present['is_wechat']);
        $ad->weight = trim($present['weight']);
        $ad->put_date_start = trim($put_date_start);
        $ad->put_date_stop = trim($put_date_stop);
        $ad->state = $present['state'];

        $ad->is_hour_weight = trim($present['is_hour_weight']);
        if($present['is_hour_weight']=='1'){
            $ad->categorys = $present['categorys'];
        }

        $ad->is_put_category = trim($present['is_put_category']);
        if($present['is_put_category']=='1'){
            $ad->categorys = $present['categorys'];
        }
        
        $ad->is_put_hour = $present['is_put_hour'];
        if($present['is_put_hour']=='1'){
            $ad->hours = $present['hours'];
        }
        
        if($ad->save())
        {
            return response()->json(['message'=>'添加成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'添加失败'], 300);
        }
        
    }

}