<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use App\Model\Advertiser;
use App\Model\Webmaster;
use App\Model\Users;

use Session;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static $user;

    //广告主登录
    public static function Advertiser()
    {
        $advertiser_id = Session::get('advertiser_id');
        $advertiser_name = Session::get('advertiser_name');

        if(empty($advertiser_id) || empty($advertiser_name))
        {
            self::response_json(['message'=>'没有登陆，请登陆。', 'url'=>'/login/ad'], 300);
        }

        $advertiser = Advertiser::where('id', '=', $advertiser_id)->where('username', '=', $advertiser_name)->first();

        if(empty($advertiser))
        {
            self::response_json(['message'=>'用户已经失效，请从新登陆。', 'url'=>'/login/ad'], 300);
        }

        if($advertiser->state=='2')
        {
            self::response_json(['message'=>'账号被封，请联系你的专属客服。', 'url'=>'/'], 300);
        }

        self::$user = $advertiser;
    }

    //网站主登录
    public static function Webmaster()
    {
        $webmaster_id = Session::get('webmaster_id');
        $webmaster_name = Session::get('webmaster_name');

        if(empty($webmaster_id) || empty($webmaster_name))
        {
            self::response_json(['message'=>'没有登陆，请登陆。', 'url'=>'/login/web'], 300);
        }

        $webmaster = Webmaster::where('id', '=', $webmaster_id)->where('username', '=', $webmaster_name)->first();

        if(empty($webmaster))
        {
            self::response_json(['message'=>'用户已经失效，请从新登陆。', 'url'=>'/login/web'], 300);
        }

        if($webmaster->state=='2')
        {
            self::response_json(['message'=>'账号被封，请联系你的专属客服。', 'url'=>'/'], 300);
        }

        self::$user = $webmaster;
    }


    //后台管理员登录
    public static function Admin()
    {
        $user_id = Session::get('user_id');
        $user_name = Session::get('user_name');

        if(empty($user_id) || empty($user_name))
        {
            self::response_json(['message'=>'没有登陆，请登陆。', 'url'=>'/admin/login'], 300);
        }

        $user = Users::where('id', '=', $user_id)->where('username', '=', $user_name)->first();

        if(empty($user))
        {
            self::response_json(['message'=>'用户已经失效，请从新登陆。', 'url'=>'/admin/login'], 300);
        }

        if($user->state=='2')
        {
            self::response_json(['message'=>'账号被封，请联系你的专属客服。', 'url'=>'/admin/login'], 300);
        }

        self::$user = $user;
    }

    
    //json格式输出
    public static function response_json($data, $status)
    {
        header('Content-Type:application/json; charset=utf-8');

        header("HTTP/1.0 ".$status." OK");

        die(json_encode($data, true));
    }
}
