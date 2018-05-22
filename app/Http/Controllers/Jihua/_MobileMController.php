<?php
namespace App\Http\Controllers\Jihua;

use Illuminate\Support\Facades\Redis;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Helpers\ClientUtil;
use App\Http\Helpers\Helper;
use App\Model\StatBrowser;
use App\Model\StatInterval;
use App\Model\StatLocation;
use App\Model\StatMobile;
use App\Model\StatRegion;
use App\Model\StatScreen;
use Agent;

class MobileMController extends BaseController
{
    //迁移和更新数据 这里只迁移今天的
    public static function Mobile()
    {
        //$date = date("Y-m-d",strtotime("-3 day"));
        $date = date("Y-m-d");

        //迁移浏览器
        self::MobileBrowser($date);
        
        //迁移间隔时间
        self::MobileInterval($date);

        //迁移点击位置
        self::MobileLocation($date);

        //迁移手机
        self::MobileMobile($date);
        
        //迁移地区
        self::MobileRegion($date);

        //迁移分辨率
        self::MobileScreen($date);  
    }

    //迁移浏览器
    public static function MobileBrowser($date)
    {
        $data = Redis::hgetall('lhmob_browser_'.date('Ymd', strtotime($date.' 00:00:00')));

        foreach($data as $k=>$v)
        {
            $val = json_decode($v, true);

            $browser = StatBrowser::where('webmaster_id', '=', $val['webmaster_id'])
                ->where('myads_id', '=', $val['myads_id'])
                ->where('browser', '=', $val['browser'])
                ->where('data', '=', $date)
                ->first();

            if(empty($browser))
            {
                $browser = new StatBrowser;
            }
            
            $browser->webmaster_id = $val['webmaster_id'];
            $browser->myads_id = $val['myads_id'];
            $browser->browser = $val['browser'];
            $browser->ip = $val['ip'];
            $browser->pv = $val['pv'];
            $browser->clickip = $val['clickip'];
            $browser->clickpv = $val['clickpv'];
            $browser->data = $date;

            $browser->save();

            echo "\n";
            
        }
    }

    //迁移间隔时间
    public static function MobileInterval($date)
    {
        $data = Redis::hgetall('lhmob_interval_'.date('Ymd', strtotime($date.' 00:00:00')));
        
        foreach($data as $k=>$v)
        {
            $val = json_decode($v, true);

            $interval = StatInterval::where('webmaster_id', '=', $val['webmaster_id'])
                ->where('myads_id', '=', $val['myads_id'])
                ->where('interval', '=', $val['interval'])
                ->where('data', '=', $date)
                ->first();

            if(empty($interval))
            {
                $interval = new StatInterval;
            }
            
            $interval->webmaster_id = $val['webmaster_id'];
            $interval->myads_id = $val['myads_id'];
            $interval->interval = $val['interval'];
            $interval->clickip = $val['clickip'];
            $interval->clickpv = $val['clickpv'];
            $interval->data = $date;

            $interval->save();

            echo "\n";
        }
    }

    //迁移点击位置
    public static function MobileLocation($date)
    {
        $data = Redis::hgetall('lhmob_location_'.date('Ymd', strtotime($date.' 00:00:00')));
        
        foreach($data as $k=>$v)
        {
            $val = json_decode($v, true);

            $location = StatLocation::where('webmaster_id', '=', $val['webmaster_id'])
                ->where('myads_id', '=', $val['myads_id'])
                ->where('location', '=', $val['location'])
                ->where('data', '=', $date)
                ->first();

            if(empty($location))
            {
                $location = new StatLocation;
            }
            
            $location->webmaster_id = $val['webmaster_id'];
            $location->myads_id = $val['myads_id'];
            $location->location = $val['location'];
            $location->clickip = $val['clickip'];
            $location->clickpv = $val['clickpv'];
            $location->data = $date;

            $location->save();

            echo "\n";
        }
    }

    //迁移手机
    public static function MobileMobile($date)
    {
        $data = Redis::hgetall('lhmob_mobile_'.date('Ymd', strtotime($date.' 00:00:00')));
        
        foreach($data as $k=>$v)
        {
            $val = json_decode($v, true);

            $mobile = StatMobile::where('webmaster_id', '=', $val['webmaster_id'])
                ->where('myads_id', '=', $val['myads_id'])
                ->where('mobile', '=', $val['mobile'])
                ->where('data', '=', $date)
                ->first();

            if(empty($mobile))
            {
                $mobile = new StatMobile;
            }
            
            $mobile->webmaster_id = $val['webmaster_id'];
            $mobile->myads_id = $val['myads_id'];
            $mobile->mobile = $val['mobile'];
            $mobile->ip = $val['ip'];
            $mobile->pv = $val['pv'];
            $mobile->clickip = $val['clickip'];
            $mobile->clickpv = $val['clickpv'];
            $mobile->data = $date;

            $mobile->save();

            echo "\n";
        }
    }

    //迁移地区
    public static function MobileRegion($date)
    {
        $data = Redis::hgetall('lhmob_region_'.date('Ymd', strtotime($date.' 00:00:00')));
        
        foreach($data as $k=>$v)
        {
            $val = json_decode($v, true);

            $region = StatRegion::where('webmaster_id', '=', $val['webmaster_id'])
                ->where('myads_id', '=', $val['myads_id'])
                ->where('country', '=', $val['country'])
                ->where('region', '=', $val['region'])
                ->where('city', '=', $val['city'])
                ->where('data', '=', $date)
                ->first();

            if(empty($region))
            {
                $region = new StatRegion;
            }
            
            $region->webmaster_id = $val['webmaster_id'];
            $region->myads_id = $val['myads_id'];
            $region->country = $val['country'];
            $region->region = $val['region'];
            $region->city = $val['city'];
            $region->ip = $val['ip'];
            $region->pv = $val['pv'];
            $region->clickip = $val['clickip'];
            $region->clickpv = $val['clickpv'];
            $region->data = $date;

            $region->save();

            echo "\n";
        }
    }

    //迁移分辨率
    public static function MobileScreen($date)
    {
        $data = Redis::hgetall('lhmob_screen_'.date('Ymd', strtotime($date.' 00:00:00')));
       
        foreach($data as $k=>$v)
        {
            $val = json_decode($v, true);

            $screen = StatScreen::where('webmaster_id', '=', $val['webmaster_id'])
                ->where('myads_id', '=', $val['myads_id'])
                ->where('screen', '=', $val['screen'])
                ->where('data', '=', $date)
                ->first();

            if(empty($screen))
            {
                $screen = new StatScreen;
            }
            
            $screen->webmaster_id = $val['webmaster_id'];
            $screen->myads_id = $val['myads_id'];
            $screen->screen = $val['screen'];
            $screen->ip = $val['ip'];
            $screen->pv = $val['pv'];
            $screen->clickip = $val['clickip'];
            $screen->clickpv = $val['clickpv'];
            $screen->data = $date;

            $screen->save();

            echo "\n";
        }
    }

}