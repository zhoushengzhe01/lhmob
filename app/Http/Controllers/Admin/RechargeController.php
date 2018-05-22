<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\Advertiser;
use App\Model\AdvertiserRecharge;
use App\Model\AdvertiserMoneyLog;



class RechargeController extends ApiController
{

    public function getRecharges(Request $request)
    {
        self::Admin();

        //网站搜索
        $date = trim($request->input('date'));
        $advertiser_id = trim($request->input('advertiser_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $recharges = AdvertiserRecharge::where('id', '<>', '0');

        if(!empty($date))
            $recharges = $recharges->where('created_at', '>=', $date.' 00:00:00')->where('created_at', '<=', $date.' 23:59:59');

        if(!empty($advertiser_id))
            $recharges = $recharges->where('advertiser_id', '=', $advertiser_id);

        $count = $recharges->count();
        $recharges = $recharges->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'recharges'=>$recharges,
        ];
        
        return response()->json(['data'=>$data], 200);
    }

    public function getRecharge(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $recharge = AdvertiserRecharge::where('id', '=', $id)->first();

        if(empty($recharge))
            return response()->json(['message'=>'未找到数据'], 300);

        return response()->json(['data'=>['message'=>$recharge]], 200);
    }

    public function putRecharge(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $recharge = AdvertiserRecharge::where('id', '=', $id)->first();

        if(empty($recharge))
            return response()->json(['message'=>'未找到数据'], 300);

        if($recharge->state=='4')
        {
            return response()->json(['message'=>'充值已经完成无需在操作'], 300);
        }
        
        
        $present = $request->input();

        if(!empty($present['money'])){ $recharge->money = $present['money']; }

        if(!empty($present['outname'])){ $recharge->outname = $present['outname']; }

        if(!empty($present['message'])){ $recharge->message = $present['message']; }

        if(!empty($present['state'])){ $recharge->state = $present['state']; }
        

        $advertiser = Advertiser::where('id', '=', $recharge->advertiser_id)->first();

        if(empty($advertiser))
        {
            return response()->json(['message'=>'找不到广告主'], 300);
        }


        if($recharge->save())
        {
            if($present['state']=='4')
            {
                //修改余额
                $advertiser->money += $recharge->money;
                $advertiser->save();

                //变动日志
                $moneyLog = new AdvertiserMoneyLog;
                $moneyLog->advertiser_id = $recharge->advertiser_id;
                $moneyLog->money = $recharge->money;
                $moneyLog->message = "账户充值";
                $moneyLog->save();

            }

            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }
    }
}
