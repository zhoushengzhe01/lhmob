<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\AdvertiserLoginLog;
use App\Model\Advertiser;
use App\Model\Users;
use Hash;

class AdvertiserController extends ApiController
{

    public function getAdvertisers(Request $request)
    {
        self::Admin();

        //网站杜索
        $id = trim($request->input('id'));
        $username = trim($request->input('username'));
        $qq = trim($request->input('qq'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $advertisers = Advertiser::where('id', '<>', '0');

        if(!empty($username))
            $advertisers = $advertisers->where('username', 'like', '%'.$username.'%');

        if(!empty($id))
            $advertisers = $advertisers->where('id', '=', $id);

        if(!empty($qq))
            $advertisers = $advertisers->where('qq', '=', $qq);

        $count = $advertisers->count();
        $advertisers = $advertisers->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'advertisers'=>$advertisers,
        ];
        
        return response()->json(['data'=>$data], 200);
    }

    public function getAdvertiser(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        

        $advertiser = Advertiser::where('id', '=', $id)->first();


        if(empty($advertiser))
            return response()->json(['message'=>'未找到数据'], 300);


        return response()->json(['data'=>['advertiser'=>$advertiser]], 200);
    
    }

    public function putAdvertiser(Request $request, $id)
    {
        self::Admin();

        if(empty($id))
            return response()->json(['message'=>'缺少参数'], 400);
        
        $present = $request->input();

        $advertiser = Advertiser::where('id', '=', $id)->first();

        if(empty($advertiser))
            return response()->json(['message'=>'未找到数据'], 300);


        if(!empty($present['nickname'])){ $advertiser->nickname = trim($present['nickname']); }

        if(!empty($present['password'])){ $advertiser->password = bcrypt($present['password']); }
        
        if(!empty($present['company'])){ $advertiser->company = trim($present['company']); }
        
        if(!empty($present['email'])){ $advertiser->email = trim($present['email']); }
        
        if(!empty($present['mobile'])){ $advertiser->mobile = trim($present['mobile']); }
        
        if(!empty($present['qq'])){ $advertiser->qq = trim($present['qq']); }
        
        if(!empty($present['state'])){ $advertiser->state = trim($present['state']); }

        if(!empty($present['busine_id']))
        {
            $user = Users::where('id', '=', trim($present['busine_id']))->first();

            if(empty($user))
                return response()->json(['message'=>'找不到次商务'], 300);
            else
                $advertiser->busine_id = trim($present['busine_id']);
        }
        
        if($advertiser->save())
        {
            return response()->json(['message'=>'添加成功'], 200);
        }
        else
        {
            return response()->json(['message'=>'添加失败'], 300);
        }
    }

    public function getLoginlogs(Request $request)
    {
        self::Admin();

        //网站杜索
        $date = trim($request->input('date'));
        $webmaster_id = trim($request->input('webmaster_id'));
        $offset = trim($request->input('offset'));
        $limit = trim($request->input('limit'));
        if(empty($limit))
        {
            $limit = 10;
        }

        $loginlogs = AdvertiserLoginLog::where('id', '<>', '0');

        if(!empty($date))
            $loginlogs = $loginlogs->where('created_at', '>=', $date.' 00:00:00')->where('created_at', '<=', $date.' 23:59:59');
        
        if(!empty($webmaster_id))
            $loginlogs = $loginlogs->where('webmaster_id', '=', $webmaster_id);

        $count = $loginlogs->count();
        $loginlogs = $loginlogs->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

        $data = [
            'count'=>$count,
            'loginlogs'=>$loginlogs,
        ];
        
        return response()->json(['data'=>$data], 200);
    }
}
