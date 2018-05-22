<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\WebmasterMoney;

class TakemoneyController extends ApiController
{

    public function getTakemoneys(Request $request)
    {
        self::Admin();

        //网站搜索
        $date = trim($request->input('date'));
        $webmaster_id = trim($request->input('webmaster_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $moneys = WebmasterMoney::where('id', '<>', '0');

        if(!empty($date))
            $moneys = $moneys->where('created_at', '>=', $date.' 00:00:00')->where('created_at', '<=', $date.' 23:59:59');

        if(!empty($webmaster_id))
            $moneys = $moneys->where('webmaster_id', '=', $webmaster_id);

        $count = $moneys->count();
        $moneys = $moneys->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'takemoneys'=>$moneys,
        ];
        
        return response()->json(['data'=>$data], 200);

    }

    public function getTakemoney(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);

        $money = WebmasterMoney::where('id', '=', $id)->first();

        if(empty($money))
            return response()->json(['message'=>'未找到数据'], 300);

        return response()->json(['data'=>['takemoney'=>$money]], 200);
    }

    public function putTakemoney(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $money = WebmasterMoney::where('id', '=', $id)->first();

        if(empty($money))
            return response()->json(['message'=>'未找到数据'], 300);
        

        $present = $request->input();

        if(!empty($present['money'])){ $money->money = $present['money']; }

        if(!empty($present['state'])){ $money->state = $present['state']; }

        if(!empty($present['message'])){ $money->message = $present['message']; }

        if(!empty($present['bank_branch'])){ $money->bank_branch = $present['bank_branch']; }

        if(!empty($present['bank_name'])){ $money->bank_name = $present['bank_name']; }

        if(!empty($present['bank_card'])){ $money->bank_card = $present['bank_card']; }

        if(!empty($present['bank_account'])){ $money->bank_account = $present['bank_account']; }

        if($money->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }
    }
}
