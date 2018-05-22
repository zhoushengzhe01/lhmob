<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\WebmasterReward;

class RewardController extends ApiController
{

    public function getRewards(Request $request)
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

        $rewards = WebmasterReward::where('id', '<>', '0');

        if(!empty($date))
            $rewards = $rewards->where('created_at', '>=', $date.' 00:00:00')->where('created_at', '<=', $date.' 23:59:59');

        if(!empty($webmaster_id))
            $rewards = $rewards->where('webmaster_id', '=', $webmaster_id);

        $count = $rewards->count();
        $rewards = $rewards->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'rewards'=>$rewards,
        ];
        
        return response()->json(['data'=>$data], 200);

    }

    public function getReward(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $reward = WebmasterReward::where('id', '=', $id)->first();

        if(empty($reward))
            return response()->json(['message'=>'未找到数据'], 300);

        return response()->json(['data'=>['message'=>$reward]], 200);
    }

    public function putReward(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $reward = WebmasterReward::where('id', '=', $id)->first();

        if(empty($reward))
            return response()->json(['message'=>'未找到数据'], 300);
        

        $present = $request->input();

        if(!empty($present['note'])){ $reward->note = $present['note']; }

        if($present->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }
    }

    public function postReward(Request $request)
    {
        self::Admin();

        $present = $request->input();

        if(empty($present['webmaster_id']))
            return response()->json(['message'=>'请输入站长'], 300);
        
        if(empty($present['money']))
            return response()->json(['message'=>'请输入金额'], 300);

        if(empty($present['note']))
            return response()->json(['message'=>'请输入说明'], 300);
        
        $reward = new WebmasterReward;
        $reward->webmaster_id = trim($present['webmaster_id']);
        $reward->money = trim($present['money']);
        $reward->note = trim($present['note']);
        
        if($reward->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }
    }
}
