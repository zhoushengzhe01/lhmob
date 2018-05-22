<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\AllianceFlux;
use App\Model\AllianceFluxExpend;

use Hash;

class AllianceFluxController extends ApiController
{

    public function getAllianceFluxs(Request $request)
    {
        self::Admin();

        //网站杜索
        $adstype_id = trim($request->input('adstype_id'));
        $name = trim($request->input('name'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $fluxs = AllianceFlux::where('id', '<>', '0');

        if(!empty($adstype_id))
            $fluxs = $fluxs->where('adstype_id', '=', $adstype_id);

        if(!empty($title))
            $fluxs = $fluxs->where('name', 'like', '%'.$name.'%');

        $count = $fluxs->count();
        $fluxs = $fluxs->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'fluxs'=>$fluxs,
        ];
        
        return response()->json(['data'=>$data], 200);
    }

    public function getAllianceFlux(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);        

        $flux = AllianceFluxExpend::where('id', '=', $id)->first();
        
        if(empty($flux))
            return response()->json(['message'=>'未找到数据'], 300);
        
        return response()->json(['data'=>['flux'=>$flux]], 200);    
    }

    public function putAllianceFlux(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
        {
            return response()->json(['message'=>'缺少参数'], 400);
        }

        $present = $request->input();

        $flux = AllianceFlux::where('id', '=', $id)->first();

        if(!empty($present['name'])){ $flux->name = trim($present['name']); }
         
        if(!empty($present['adstype_id'])){ $flux->adstype_id = trim($present['adstype_id']); }
         
        if(!empty($present['account'])){ $flux->account = trim($present['account']); }
         
        if(!empty($present['password'])){ $flux->password = trim($present['password']); }
         
        if(!empty($present['url'])){ $flux->url = trim($present['url']); }
         
        if(!empty($present['record_num'])){ $flux->record_num = trim($present['record_num']); }
         
        if(!empty($present['budget']) || $present['budget']=='0'){ $flux->budget = trim($present['budget']); }
         
        if(!empty($present['budget_day']) || $present['budget_day']=='0'){ $flux->budget_day = trim($present['budget_day']); }
        
        if(!empty($present['in_price_ratio']) || $present['in_price_ratio']=='0'){ $flux->in_price_ratio = trim($present['in_price_ratio']); }
        
        if(!empty($present['out_price_ratio']) || $present['out_price_ratio']=='0'){ $flux->out_price_ratio = trim($present['out_price_ratio']); }

        if(!empty($present['state'])){ $flux->state = trim($present['state']); }
        
        if($flux->save())
        {
            return response()->json(['message'=>'添加成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'添加失败'], 300);
        }
    }

    public function postAllianceFlux(Request $request)
    {
        self::Admin();

        $present = $request->input();

        if(empty($present['name']))
            return response()->json(['message'=>'请输入联盟名字'], 300);
         
        if(empty($present['adstype_id']))
            return response()->json(['message'=>'请输入选择广告类型'], 300);
         
        if(empty($present['account']))
            return response()->json(['message'=>'请输入登陆账号'], 300);
         
        if(empty($present['password']))
            return response()->json(['message'=>'请输入登陆密码'], 300);
         
        if(empty($present['url']))
            return response()->json(['message'=>'请输入联盟网址'], 300);
         
        if(empty($present['record_num']))
            return response()->json(['message'=>'请输入计费次数'], 300);
         
        if(empty($present['budget']) && $present['budget']!='0')
            return response()->json(['message'=>'请输入总预算'], 300);
         
        if(empty($present['budget_day']) && $present['budget_day']!='0')
            return response()->json(['message'=>'请输入每天预算'], 300);
         
        if(empty($present['price']))
            return response()->json(['message'=>'请输入价格'], 300);

        if(empty($present['state']))
            return response()->json(['message'=>'请输入状态'], 300);
        
        $flux = new AllianceFlux;
        $flux->name = empty($present['name']);
        $flux->adstype_id = empty($present['adstype_id']);
        $flux->account = empty($present['account']);
        $flux->password = empty($present['password']);
        $flux->url = empty($present['url']);
        $flux->record_num = empty($present['record_num']);
        $flux->budget = empty($present['budget']);
        $flux->budget_day = empty($present['budget_day']);
        $flux->state = empty($present['state']);
        $flux->price = empty($present['price']);

        if($flux->save())
        {
            return response()->json(['message'=>'添加成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'添加失败'], 300);
        }

    }

}