<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\WebmasterWebsite;

class WebmasterWebsiteController extends ApiController
{

    public function getWebmasterWebsites(Request $request)
    {
        self::Admin();

        //网站搜索
        $webmaster_id = trim($request->input('webmaster_id'));
        $domain = trim($request->input('domain'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $websites = WebmasterWebsite::where('id', '<>', '0');

        if(!empty($webmaster_id))
            $websites = $websites->where('webmaster_id', '=', $webmaster_id);
        
        if(!empty($domain))
            $websites = $websites->where('domain', 'like', '%'.$domain.'%');

        $count = $websites->count();
        $websites = $websites->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'websites'=>$websites,
        ];

        return response()->json(['data'=>$data], 200);
    }

    public function getWebmasterWebsite(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);

        $website = WebmasterWebsite::where('id', '=', $id)->first();

        if(empty($website))
            return response()->json(['message'=>'未找到数据'], 300);

        return response()->json(['data'=>['website'=>$website]], 200);
    }

    public function putWebmasterWebsite(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $website = WebmasterWebsite::where('id', '=', $id)->first();

        if(empty($website))
            return response()->json(['message'=>'未找到数据'], 300);

        $present = $request->input();

        if(!empty($present['webmaster_id'])){ $website->webmaster_id = $present['webmaster_id']; }

        if(!empty($present['name'])){ $website->name = $present['name']; }

        if(!empty($present['domain'])){ $website->domain = $present['domain']; }

        if(!empty($present['category_id'])){ $website->category_id = $present['category_id']; }

        if(!empty($present['icp'])){ $website->icp = $present['icp']; }

        if(!empty($present['state']) || $present['state']==0){ $website->state = $present['state']; }
        
        if($website->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }

    }

}