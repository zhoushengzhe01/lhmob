<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\Webmaster;
use App\Model\WebmasterLog;
use App\Model\WebmasterLoginLog;
use Hash;

class WebmasterController extends ApiController
{

    public function getWebmasters(Request $request)
    {
        self::Admin();
        
        //网站搜索
        $webmaster_id = trim($request->input('webmaster_id'));
        $username = trim($request->input('username'));
        $nickname = trim($request->input('nickname'));
        $mobile = trim($request->input('mobile'));
        $qq = trim($request->input('qq'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $webmasters = Webmaster::where('id', '<>', '0');

        if(!empty($webmaster_id))
            $webmasters = $webmasters->where('id', '=', $webmaster_id);

        if(!empty($username))
            $webmasters = $webmasters->where('username', 'like', '%'.$username.'%');

        if(!empty($nickname))
            $webmasters = $webmasters->where('nickname', 'like', '%'.$nickname.'%');

        if(!empty($mobile))
            $webmasters = $webmasters->where('mobile', 'like', '%'.$mobile.'%');
        
        if(!empty($qq))
            $webmasters = $webmasters->where('qq', 'like', '%'.$qq.'%');

        $count = $webmasters->count();
        $webmasters = $webmasters->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'webmasters'=>$webmasters,
        ];

        return response()->json(['data'=>$data], 200);
    }

    public function getWebmaster(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);

        $webmaster = Webmaster::where('id', '=', $id)->first();

        if(empty($webmaster))
            return response()->json(['message'=>'未找到数据'], 300);

        $webmaster->allow_alliance = json_decode($webmaster->allow_alliance, true);
        if(gettype($webmaster->allow_alliance)!='array')
        {
            $webmaster->allow_alliance = [];
        }
        
        $webmaster->disabled_alliance = json_decode($webmaster->disabled_alliance, true);
        if(gettype($webmaster->disabled_alliance)!='array')
        {
            $webmaster->disabled_alliance = [];
        }
        
        return response()->json(['data'=>['webmaster'=>$webmaster]], 200);
    }

    public function putWebmaster(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $webmaster = Webmaster::where('id', '=', $id)->first();

        if(empty($webmaster))
            return response()->json(['message'=>'未找到数据'], 300);

        $present = $request->input();

        if(!empty($present['service_id'])){ $webmaster->service_id = $present['service_id']; }

        if(!empty($present['username'])){ $webmaster->username = $present['username']; }

        if(!empty($present['nickname'])){ $webmaster->nickname = $present['nickname']; }

        if(!empty($present['password'])){ $webmaster->password = bcrypt($present['password']);; }

        if(!empty($present['allow_alliance'])){ $webmaster->allow_alliance = json_encode($present['allow_alliance'], true); }

        if(!empty($present['disabled_alliance'])){ $webmaster->disabled_alliance = json_encode($present['disabled_alliance'], true); }

        if(!empty($present['withdrawals_state'])){ $webmaster->withdrawals_state = $present['withdrawals_state']; }

        if(!empty($present['withdrawals_type'])){ $webmaster->withdrawals_type = $present['withdrawals_type']; }

        if(!empty($present['money'])){ $webmaster->money = $present['money']; }

        if(!empty($present['email'])){ $webmaster->email = $present['email']; }

        if(!empty($present['mobile'])){ $webmaster->mobile = $present['mobile']; }

        if(!empty($present['qq'])){ $webmaster->qq = $present['qq']; }

        if(!empty($present['state'])){ $webmaster->state = $present['state']; }

        if(!empty($present['is_limit_domain'])){ $webmaster->is_limit_domain = $present['is_limit_domain']; }

        if(!empty($present['website'])){ $webmaster->website = $present['website']; }


        if($webmaster->save())
        {
            return response()->json(['message'=>'修改成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'修改失败'], 300);
        }

    }

    public function getWebmasterLoginlogs(Request $request)
    {
        self::Admin();

        //网站搜索
        $webmaster_id = trim($request->input('webmaster_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $logs = WebmasterLoginLog::where('id', '<>', '0');

        if(!empty($webmaster_id))
            $logs = $logs->where('webmaster_id', '=', $webmaster_id);

        $count = $logs->count();
        $logs = $logs->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'logs'=>$logs,
        ];

        return response()->json(['data'=>$data], 200);
    }
}
