<?php
namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Advertiser;
use App\Model\Users;
use Hash;
use Session;

class BaseController extends Controller
{
    //广告主
    public static function getAdvertiser()
    {
        $advertiser_id = Session::get('advertiser_id');
        $advertiser_name = Session::get('advertiser_name');

        if(empty($advertiser_id) || empty($advertiser_name))
        {
            self::info('没有登陆，请登陆。', '/login');
        }
        $advertiser = Advertiser::where('id', '=', $advertiser_id)->where('username', '=', $advertiser_name)->first();

        if(empty($advertiser))
        {
            die(self::info('用户已经失效，请从新登陆。', '/login'));
        }

        if($advertiser->state=='2')
        {
            die(self::info('账号被封，请联系你的专属客服。', '/'));
        }

        //查找商务
        $advertiser->busine = Users::where('id', '=', $advertiser->busine_id)->first();

        self::$group['advertiser'] = $advertiser;
    }
}