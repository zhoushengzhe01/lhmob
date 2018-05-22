<?php
namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Model\AdvertiserExpendDay;
use App\Model\AdvertiserExpendHour;


class ExpendController extends ApiController
{
    //获坖
    public function getExpends(Request $request, $type)
    {
        self::Advertiser();

        $date = trim($request->input('date'));
        $ads_id = trim($request->input('ads_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        if($type=='day')
        {
            $expends = AdvertiserExpendDay::where('advertiser_id', '=', self::$user->id);
        }
        if($type=='hour')
        {
            $expends = AdvertiserExpendHour::where('advertiser_id', '=', self::$user->id);
        }

        if(!empty($date))
        {
            $expends = $expends->where('created_at', '>=', $date.' 00:00:00')->where('created_at', '<=', $date.' 23:59:59');
        }
        if(!empty($ads_id))
        {
            $expends = $expends->where('ads_id', '=', $ads_id);
        }


        $count = $expends->count();
        $expends = $expends->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
        
        $data = [
            'count'=>$count,
            'expends'=>$expends,
        ];

        return response()->json(['data'=>$data], 200);
    }
}








