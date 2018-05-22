<?php
namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Model\AdvertiserAds;

class AdsController extends ApiController
{
    //获取
    public function getAds(Request $request)
    {
        self::Advertiser();

        $title = trim($request->input('title'));
        $adstype_id = trim($request->input('adstype_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }
      
        //我的素材
        $ads = AdvertiserAds::where('advertiser_id', '=', self::$user->id);
        if(!empty($title))
        {
            $ads = $ads->where('title', 'like', '%'.$title.'%');
        }
        if(!empty($adstype_id))
        {
            $ads = $ads->where('adstype_id', '=', $adstype_id);
        }
        $count = $ads->count();
        $ads = $ads->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'ads'=>$ads,
        ];

        return response()->json(['data'=>$data], 200);
    }

    //获取一条
    public function getAd(Request $request, $id)
    {
        self::Advertiser();
        
        if(empty($id))
        {
            return response()->json(['message'=>'缺少参数'], 400);
        }

        $ad = AdvertiserAds::where('id', '=', $id)->where('advertiser_id', '=', self::$user->id)->first();

        if(empty($ad))
        {
            return response()->json(['message'=>'未找到数据'], 300);
        }

        $ad->hour_weight = empty($ad->hour_weight) ? [] : json_decode($ad->hour_weight, true);
        $ad->webmasters = empty($ad->webmasters) ? [] : json_decode($ad->webmasters, true);
        $ad->categorys = empty($ad->categorys) ? [] : json_decode($ad->categorys, true);
        $ad->hours = empty($ad->hours) ? [] : json_decode($ad->hours, true);
        $ad->date = [
            $ad->put_date_start,
            $ad->put_date_stop,
        ];

        return response()->json(['data'=>['ad'=>$ad]], 200);
    }

    //添加
    public function postAd(Request $request)
    {
        self::Advertiser();
        
        $present = $request->input();

        if(empty($present['title'])){
            return response()->json(['message'=>'请填写广告标题'], 300);
        }
        if(empty($present['link'])){
            return response()->json(['message'=>'请填写推广地址'], 300);
        }
        if(empty($present['adstype_id']) && $present['adstype_id']!='0'){
            return response()->json(['message'=>'请选择广告类型'], 300);
        }
        if(empty($present['price_type']) && $present['price_type']!='0'){
            return response()->json(['message'=>'请选择计费方式'], 300);
        }
        if(empty($present['client']) && $present['client']!='0'){
            return response()->json(['message'=>'请选择投放类型'], 300);
        }
        if(empty($present['is_wechat']) && $present['is_wechat']!='0'){
            return response()->json(['message'=>'请选择是非微信流量'], 300);
        }
        if(empty($present['package_id'])){
            return response()->json(['message'=>'请选择广告素材包'], 300);
        }

        $ad = new AdvertiserAds;
        $ad->advertiser_id = self::$user->id;
        $ad->adstype_id = intval($present['adstype_id']);
        $ad->package_id = intval($present['package_id']);
        $ad->title = trim($present['title']);
        $ad->link = trim($present['link']);
        $ad->in_price = 100;
        $ad->out_price = 40;
        $ad->price_type = trim($present['price_type']);
        $ad->budget = trim($present['budget']);
        $ad->budget_day = trim($present['budget_day']);
        $ad->client = trim($present['client']);
        $ad->is_wechat = trim($present['is_wechat']);
        $ad->weight = '100';
        $ad->is_hour_weight = '0';
        $ad->is_put_webmaster = '0';
        $ad->is_put_category = trim($present['is_put_category']);
        $ad->is_put_hour = $present['is_put_hour'];
        $ad->state = $present['state'];

        if(!empty($present['date']) && count($present['date'])==2)
        {
            $ad->put_date_start = $present['date'][0];
            $ad->put_date_stop = $present['date'][1];
        }
        
        if($present['is_put_hour']=='1')
        {
            if(count($present['hours'])<10)
            {
                return response()->json(['message'=>'限制时间至少选择10个小时'], 300);
            }else
            {
                $ad->hours = json_encode($present['hours'], true);
            }
        }
        if($present['is_put_category']=='1')
        {
            if(count($present['categorys'])<3)
            {
                return response()->json(['message'=>'开启分类限制至少选三个分类'], 300);
            }else
            {
                $ad->categorys = json_encode($present['categorys'], true);
            }
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

    //修改
    public function putAd(Request $request, $id)
    {
        self::Advertiser();
        
        if(empty($id))
        {
            return response()->json(['message'=>'缺少参数'], 400);
        }

        $ad = AdvertiserAds::where('advertiser_id', '=', self::$user->id)->where('id', '=', $id)->first();

        $present = $request->input();

        if(!empty($present['title'])){ $ad->title = $present['title']; }

        if(!empty($present['link'])){ $ad->link = $present['link']; }

        if(!empty($present['adstype_id'])){ $ad->adstype_id = $present['adstype_id']; }

        if(!empty($present['price_type'])){ $ad->price_type = $present['price_type']; }

        if(!empty($present['client']) || $present['client']=='0'){ $ad->client = $present['client']; }

        if(!empty($present['is_wechat']) || $present['is_wechat']=='0'){ $ad->is_wechat = $present['is_wechat']; }

        if(!empty($present['package_id'])){ $ad->package_id = $present['package_id']; }

        if(!empty($present['is_put_category']) || $present['is_put_category']=='0'){ $ad->is_put_category = $present['is_put_category']; }

        if(!empty($present['package_id']) || $present['package_id']=='0'){ $ad->package_id = $present['package_id']; }

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

        if($present['is_put_category']=='1')
        {
            if(count($present['categorys'])<3)
            {
                return response()->json(['message'=>'开启分类限制至少选三个分类'], 300);
            }else
            {
                $ad->categorys = json_encode($present['categorys'], true);
            }
        }

        if($present['is_put_hour']=='1')
        {
            if(count($present['hours'])<10)
            {
                return response()->json(['message'=>'限制时间至少选择10个小时'], 300);
            }else
            {
                $ad->hours = json_encode($present['hours'], true);
            }
        }

        if($ad->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }
    }
}








