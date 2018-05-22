<?php
namespace App\Http\Controllers\Jihua;

use Illuminate\Support\Facades\Redis;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Helpers\ClientUtil;
use App\Http\Helpers\Helper;
use Agent;

class StatDataPvController extends BaseController
{
    //PV数据处理分析
    public static function StatData()
    {   
        
        while ( $data = json_decode(Redis::rpop("lhmob_pv"), true) ) 
        {
            $data['data'] = date('Ymd', strtotime($data['created_at']));

            //访问的IP处理
            $key = strtolower($data['ip'].'@'.$data['myads_id']);
            $statip = Redis::hget('lhmob_ip_'.$data['data'], $key);
            
            if($statip)
            {
                $is_new_ip = false;
                $statip = json_decode($statip, true);

                $statip['pv'] = $statip['pv']+1;
            }
            else
            {
                $is_new_ip = true;
                $statip = [
                    'webmaster_id'=>$data['webmaster_id'],
                    'myads_id'=>$data['myads_id'],
                    "ip" => $data['ip'],
                    "pv" => 1,
                ];
            }
            //修改储存
            Redis::hset('lhmob_ip_'.$data['data'], $key, json_encode($statip, true));
            
            //按照手机统计
            self::statMobile($data, $is_new_ip);
            
            //按照地区统计
            self::statRegion($data, $is_new_ip);
            
            //按照地区分布
            self::statBrowser($data, $is_new_ip);

            //按照分辨率分布
            self::statScreen($data, $is_new_ip);
            
            //echo '位置:'.$data['created_at']."\n";
            //die;
        }
    }

    //按照手机型号处理
    public static function statMobile($data, $is_new_ip)
    {
        if(!empty($data['user_agent']))
        {
            preg_match('/\([iPhone|Linux]+; [0-9a-zA-Z\ \;\-\/\.\_]+\)/', $data['user_agent'], $matches);
            if(!empty($matches[0]))
            {
                $mobileBrand = Helper::getMobileBrand($matches[0]);
                $key = strtolower($mobileBrand.'@'.$data['myads_id']);

                $mobile = Redis::hget('lhmob_mobile_'.$data['data'], $key);
                if($mobile)
                {
                    $mobile = json_decode($mobile, true);
                    //是新的IP
                    if($is_new_ip)
                    {
                        $mobile['ip'] = $mobile['ip']+1;
                        $mobile['pv'] = $mobile['pv']+1;
                    }
                    else
                    {
                        $mobile['pv'] = $mobile['pv']+1;
                    }
                }
                else
                {
                    $mobile = [
                        'mobile'=>$mobileBrand,
                        'webmaster_id'=>$data['webmaster_id'],
                        'myads_id'=>$data['myads_id'],
                        "ip" => 1,
                        "pv" => 1,
                        "clickip" => 0,
                        "clickpv" => 0,
                    ];
                }
                Redis::hset('lhmob_mobile_'.$data['data'], $key, json_encode($mobile, true));
            }

        }
        
    }

    //按照地区进行处理
    public static function statRegion($data, $is_new_ip)
    {
        if(!empty($data['ip']))
        {
            $city = Helper::getCityByip($data['ip']);
            
            if($city)
            {
                $key = $city['city_id'].'@'.$data['myads_id'];
                $region = Redis::hget('lhmob_region_'.$data['data'], $key);
                
                if($region)
                {
                    $region = json_decode($region, true);
                    if($is_new_ip)
                    {
                        $region['ip'] = $region['ip']+1;
                        $region['pv'] = $region['pv']+1;
                    }
                    else
                    {
                        $region['pv'] = $region['pv']+1;
                    }
                }
                else
                {
                    $region = [
                        'webmaster_id'=>$data['webmaster_id'],
                        'myads_id'=>$data['myads_id'],
                        'country'=>$city['country'],
                        'region'=>$city['region'],
                        'city'=>$city['city'],
                        'isp'=>$city['isp'],
                        "ip" => 1,
                        "pv" => 1,
                        "clickip" => 0,
                        "clickpv" => 0,
                    ];
                }

                Redis::hset('lhmob_region_'.$data['data'], $key, json_encode($region, true));
            }
        }
    }

    //按照浏览器统计
    public static function statBrowser($data, $is_new_ip)
    {
        $browserName = ClientUtil::getBrowser($data['user_agent']);
        if(empty($browserName))
        {
            $browserName = 'unknown';
        }
        $key = strtolower($browserName.'@'.$data['myads_id']);
        $browser = Redis::hget('lhmob_browser_'.$data['data'], $key);
        if($browser)
        {
            $browser = json_decode($browser, true);
            if($is_new_ip)
            {
                $browser['ip'] = $browser['ip']+1;
                $browser['pv'] = $browser['pv']+1;
            }
            else
            {
                $browser['pv'] = $browser['pv']+1;
            }
        }
        else
        {
            $browser = [
                'webmaster_id'=>$data['webmaster_id'],
                'myads_id'=>$data['myads_id'],
                'browser'=>$browserName,
                "ip" => 1,
                "pv" => 1,
                "clickip" => 0,
                "clickpv" => 0,
            ];
        }
        Redis::hset('lhmob_browser_'.$data['data'], $key, json_encode($browser, true));
    }

    //按照分辨率统计
    public static function statScreen($data, $is_new_ip)
    {
        $key = strtolower($data['screen'].'@'.$data['myads_id']);
        $screen = Redis::hget('lhmob_screen_'.$data['data'], $key);
        if($screen)
        {
            $screen = json_decode($screen, true);
            if($is_new_ip)
            {
                $screen['ip'] = $screen['ip']+1;
                $screen['pv'] = $screen['pv']+1;
            }
            else
            {
                $screen['pv'] = $screen['pv']+1;
            }
        }
        else
        {
            $screen = [
                'webmaster_id'=>$data['webmaster_id'],
                'myads_id'=>$data['myads_id'],
                'screen'=>$data['screen'],
                "ip" => 1,
                "pv" => 1,
                "clickip" => 0,
                "clickpv" => 0,
            ];
        }
        Redis::hset('lhmob_screen_'.$data['data'], $key, json_encode($screen, true));
    }

    
}