<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\WebmasterAds;
use App\Model\EarningDay;
use App\Model\EarningHour;

class WebmasterAdsController extends ApiController
{

    public function getWebmasterAds(Request $request)
    {
        self::Admin();

        //网站搜索
        $name = trim($request->input('name'));
        $webmaster_id = trim($request->input('webmaster_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $ads = WebmasterAds::where('webmaster_ads.id', '<>', '0')
            ->join('webmaster', 'webmaster.id','=','webmaster_ads.webmaster_id');

        if(!empty($name))
            $ads = $ads->where('webmaster_ads.name', '=', $name);

        if(!empty($webmaster_id))
            $ads = $ads->where('webmaster_ads.webmaster_id', '=', $webmaster_id);

        $count = $ads->count();
        $ads = $ads->orderBy('webmaster_ads.is_top', 'desc')->orderBy('webmaster_ads.earning_day', 'desc')->offset($offset)->limit($limit)->get(['webmaster_ads.*','webmaster.username']);
        
        //查找收益
        foreach($ads as $key=>$val)
        {
            $day = [
                ['pv'=>0, 'click'=>0, 'money'=>0, 'time'=>date('Y-m-d', strtotime("-2 day"))],
                ['pv'=>0, 'click'=>0, 'money'=>0, 'time'=>date('Y-m-d', strtotime("-1 day"))],
                ['pv'=>0, 'click'=>0, 'money'=>0, 'time'=>date('Y-m-d', strtotime("-0 day"))],
            ];
            
            $earningDay = EarningDay::where('myads_id', '=', $val->id)->where('time', '>=', date('Y-m-d', strtotime("-2 day")).' 00:00:00')->where('time', '<', date('Y-m-d', strtotime("-0 day")).' 00:00:00')->get(['pv', 'click', 'money', 'time'])->toArray();
            
            foreach($earningDay as $k=>$v)
            {
               if($v['time'] == date('Y-m-d', strtotime("-2 day")).' 00:00:00')
               {
                    $day[0]['pv'] += $v['pv'];
                    $day[0]['click'] += $v['click'];
                    $day[0]['money'] += $v['money'];
               }

               if($v['time'] == date('Y-m-d', strtotime("-1 day")).' 00:00:00')
               {
                    $day[1]['pv'] += $v['pv'];
                    $day[1]['click'] += $v['click'];
                    $day[1]['money'] += $v['money'];
               }
               
            }

            $hour = EarningHour::where('myads_id', '=', $val->id)->where('time', '>=', date('Y-m-d', strtotime("-0 day")).' 00:00:00')->where('time', '<=', date('Y-m-d', strtotime("-0 day")).' 23:59:59')->get(['pv', 'click', 'money', 'time']);

            foreach($hour as $k=>$v)
            {
                $day[2]['pv'] += $v->pv;
                $day[2]['click'] += $v->click;
                $day[2]['money'] += $v->money;
            }
            
            $ads[$key]['day'] = $day;
        }
        
        $data = [
            'count'=>$count,
            'ads'=>$ads,
        ];
        
        return response()->json(['data'=>$data], 200);
    }

    public function getWebmasterAd(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);

        $webmasterad = WebmasterAds::where('id', '=', $id)->first();

        if(empty($webmasterad))
            return response()->json(['message'=>'未找到数据'], 300);

        return response()->json(['data'=>['webmasterad'=>$webmasterad]], 200);

    }

    public function putWebmasterAd(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $ad = WebmasterAds::where('id', '=', $id)->first();

        if(empty($ad))
            return response()->json(['message'=>'未找到数据'], 300);

        $present = $request->input();

        if(!empty($present['webmaster_id'])){ $ad->webmaster_id = $present['webmaster_id']; }

        if(!empty($present['name'])){ $ad->name = $present['name']; }

        if(!empty($present['position_id'])){ $ad->position_id = $present['position_id']; }

        if(!empty($present['position_name'])){ $ad->position_name = $present['position_name']; }

        if(!empty($present['position'])){ $ad->position = $present['position']; }

        if(!empty($present['price'])){ $ad->price = $present['price']; }

        if(!empty($present['billing'])){ $ad->billing = $present['billing']; }

        if(!empty($present['in_advertiser_price'])){ $ad->in_advertiser_price = $present['in_advertiser_price']; }
        
        if(!empty($present['out_advertiser_price'])){ $ad->out_advertiser_price = $present['out_advertiser_price']; }
        
        if(!empty($present['out_alliance_price'])){ $ad->out_alliance_price = $present['out_alliance_price']; }
        
        if(!empty($present['ad_ratio']) || $present['ad_ratio']==0){ $ad->ad_ratio = $present['ad_ratio']; }
        
        if(!empty($present['false_close']) || $present['false_close']==0){ $ad->false_close = $present['false_close']; }
        
        if(!empty($present['is_check']) || $present['is_check']==0){ $ad->is_check = $present['is_check']; }
        
        if(!empty($present['hid_height']) || $present['hid_height']==0){ $ad->hid_height = $present['hid_height']; }
        
        if(!empty($present['ad_size'])){ $ad->ad_size = $present['ad_size']; }
        
        if(!empty($present['is_disabled_advertiser']) || $present['is_disabled_advertiser']=='0'){ $ad->is_disabled_advertiser = $present['is_disabled_advertiser']; }
        
        if(!empty($present['disabled_advertise'])){ $ad->disabled_advertise = $present['disabled_advertise']; }

        if(!empty($present['state'])){ $ad->state = $present['state']; }

        if(!empty($present['is_top'])){ $ad->is_top = $present['is_top']; }

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