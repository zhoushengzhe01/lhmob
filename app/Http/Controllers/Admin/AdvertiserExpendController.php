<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\AdvertiserExpendDay;
use App\Model\Advertiser;

class AdvertiserExpendController extends ApiController
{

    public function getExpends(Request $request)
    {
        self::Admin();

        //网站杜索
        $date = trim($request->input('date'));
        $ads_id = trim($request->input('ads_id'));
        $advertiser_id = trim($request->input('advertiser_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $expends = AdvertiserExpendDay::where('advertiser_expend_day.id', '<>', '0')
            ->join('advertiser', 'advertiser.id', '=', 'advertiser_expend_day.advertiser_id');

        if(!empty($date))
            $expends = $expends->where('advertiser_expend_day.date', '=', $date);

        if(!empty($ads_id))
            $expends = $expends->where('advertiser_expend_day.ads_id', '=', $ads_id);

        if(!empty($advertiser_id))
            $expends = $expends->where('advertiser_id', '=', $advertiser_id);

        $count = $expends->count();
        $expends = $expends->orderBy('id', 'desc')->offset($offset)->limit($limit)->get(['advertiser.username', 'advertiser_expend_day.*']);

        $data = [
            'count'=>$count,
            'expends'=>$expends,
        ];
        
        return response()->json(['data'=>$data], 200);
    }
    
}
