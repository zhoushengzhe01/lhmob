<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\WebmasterAds;
use App\Model\EarningDay;
use App\Model\EarningHour;
use App\Model\EarningClick;

class WebmasterEarningController extends ApiController
{

    public function getEarningDay(Request $request, $webmaster_ad_id)
    {
        self::Admin();

        if(empty($webmaster_ad_id))
            return response()->json(['message'=>'缺少广告位ID'], 400);

        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $earnings = EarningDay::where('myads_id', '=', $webmaster_ad_id);

        $count = $earnings->count();
        $earnings = $earnings->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'earnings'=>$earnings,
        ];

        return response()->json(['data'=>$data], 200);

    }

    public function getEarningHour(Request $request, $webmaster_ad_id)
    {
        self::Admin();

        if(empty($webmaster_ad_id))
            return response()->json(['message'=>'缺少站长ID'], 400);

        $date = trim($request->input('date'));
        $type = trim($request->input('type'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $earnings = EarningHour::where('myads_id', '=', $webmaster_ad_id);

        if(!empty($date))
        {
            $earnings = $earnings->where('time', '>=', $date.' 00:00:00')->where('time', '<=', $date.' 23:59:59');
        }

        $count = $earnings->count();
        $earnings = $earnings->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'earnings'=>$earnings,
        ];

        return response()->json(['data'=>$data], 200);
    }


    public function getEarningHourChart(Request $request, $webmaster_ad_id)
    {
        self::Admin();

   
        if(empty($webmaster_ad_id))
            return response()->json(['message'=>'缺少站长ID'], 400);

        $date = trim($request->input('date'));
        
        $default = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
        
        $result = EarningHour::where('myads_id', '=', $webmaster_ad_id)
            ->where('time', '>=', $date.' 00:00:00')
            ->where('time', '<=', $date.' 23:59:59')
            ->orderBy('id', 'asc')->get();

        $today = [];

        foreach($default as $key=>$val)
        {
            $data = ['money'=>0, 'click'=>0, 'pv'=>0];

            foreach($result as $k=>$v)
            {
                if(substr($v->time , 11, 2)==$val)
                {
                    $data['money'] += $v->money;
                    $data['click'] += $v->click;
                    $data['pv'] += $v->pv;
                    $data['created_at'] = $v->created_at;
                }
            }

            $today[] = $data;
        }

        
        $date = date("Y-m-d", strtotime("-1 day", strtotime($date)));

        $result = EarningHour::where('myads_id', '=', $webmaster_ad_id)
            ->where('time', '>=', $date.' 00:00:00')
            ->where('time', '<=', $date.' 23:59:59')
            ->orderBy('id', 'asc')->get();

        $yesterday = [];

        foreach($default as $key=>$val)
        {
            $data = ['money'=>0, 'click'=>0, 'pv'=>0];

            foreach($result as $k=>$v)
            {
                if(substr($v->time , 11, 2)==$val)
                {
                    $data['money'] += $v->money;
                    $data['click'] += $v->click;
                    $data['pv'] += $v->pv;
                }
            }

            $yesterday[] = $data;
        }

        $data = [
            'default'=>$default,
            'today'=>$today,
            'yesterday'=>$yesterday,
        ];

        return response()->json(['data'=>$data], 200);
    }


    public function getEarningClick(Request $request, $webmaster_ad_id)
    {
        self::Admin();

        if(empty($webmaster_ad_id))
            return response()->json(['message'=>'缺少站长ID'], 400);

        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $clicks = EarningClick::where('myads_id', '=', $webmaster_ad_id);

        $count = $clicks->count();
        $clicks = $clicks->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'clicks'=>$clicks,
        ];

        return response()->json(['data'=>$data], 200);
    }
}