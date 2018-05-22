<?php
namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Webmaster;
use App\Model\Users;
use App\Model\EarningMinute;
use App\Model\EarningHour;
use App\Model\EarningDay;
use App\Model\UsersDepartment;

use Hash;
use Session;

class _BaseController extends Controller
{
    public function __construct()
    {
        die;
        parent::__construct();
        
        //验证用户
        self::Webmaster();
    }

    //验证用户
    public static function getWebmaster()
    {
        $webmaster_id = Session::get('webmaster_id');
        $webmaster_name = Session::get('webmaster_name');

        if(empty($webmaster_id) || empty($webmaster_name))
        {
            die(self::info('没有登陆，请登陆。', '/login'));
        }

        $webmaster = Webmaster::getWebmaster(['id'=>$webmaster_id, 'username'=>$webmaster_name]);
        if(empty($webmaster))
        {
            die(self::info('用户已经失效，请从新登陆。', '/login'));
        }

        if($webmaster->state=='2')
        {
            die(self::info('账号被封，请联系你的专属客服', '/'));
        }

        //账户余额 等于 未处理 + 账户金额
        $day_money = EarningDay::where('webmaster_id', '=', $webmaster->id)
            ->where('statec', '=', '1')
            ->where('time', '>=', date('Y-m-d').' 00:00:00')
            ->sum('money');

        $hour_money = EarningHour::where('webmaster_id', '=', $webmaster->id)
            ->where('statec', '=', '1')
            ->where('time', '>=', date('Y-m-d').' 00:00:00')
            ->sum('money');
       
        $minute_money = EarningMinute::where('webmaster_id', '=', $webmaster->id)
            ->where('statec', '=', '1')
            ->where('time', '>=', date('Y-m-d').' 00:00:00')
            ->sum('money');

        $webmaster->day_money = round($day_money, 2);
        $webmaster->hour_money = round($hour_money, 2);
        $webmaster->minute_money = round($minute_money, 2);
        
        //查找客服
        $webmaster->service = Users::where('id', '=', $webmaster->service_id)->first();

        self::$data['webmaster'] = $webmaster;
    }

}
