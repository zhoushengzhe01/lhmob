<?php
namespace App\Http\Controllers\Jihua;

use Illuminate\Support\Facades\Redis;
use Illuminate\Routing\Controller as BaseController;

use App\Model\EarningPv;
use App\Model\EarningMinute;
use App\Model\EarningHour;
use App\Model\EarningDay;
use App\Model\Alliance;
use App\Model\AllianceHour;

class EarningPvController extends BaseController
{
    //PV统计10分钟处理一次
    public static function EarningMinute()
    {
        //------------------------------------------------PV结算处理------------------------------------------------
        while ( $pointer = Redis::rpop("pv_pointer") ) 
        {
            
            //获取
            $pvLibrary = json_decode(Redis::hget("pv_library", $pointer), true);

            Redis::hdel("pv_library", $pointer);

            //数据
            $type = intval($pvLibrary['type']);
            $time = $pvLibrary['time'];
            $pv = intval($pvLibrary['pv']) * 5;
            $ip = intval($pvLibrary['ip']);

            //---------------------------站长数据------------------------
            if($type=='1')
            {
                $webmaster_id = intval($pvLibrary['webmaster_id']);
                $position_id = intval($pvLibrary['position_id']);
                $myads_id = intval($pvLibrary['myads_id']);

                $earningHour = EarningHour::where('webmaster_id', '=', $webmaster_id)
                    ->where('position_id', '=', $position_id)
                    ->where('myads_id', '=', $myads_id)
                    ->where('time', '=', $time)
                    ->first();
                
                if(empty($earningHour))
                {
                    $earningHour = new EarningHour;
                    
                    $earningHour->webmaster_id = $webmaster_id;
                    $earningHour->position_id = $position_id;
                    $earningHour->myads_id = $myads_id;
                    $earningHour->time = $time;
                    $earningHour->pv = $pv;
                    $earningHour->ip = $ip;
                }
                else
                {
                    $earningHour->pv += $pv;
                    $earningHour->ip += $ip;
                }
                $earningHour->save();
            }
            //---------------------------站长数据------------------------


            //---------------------------联盟数据------------------------
            if($type=='2')
            {
                $alliance_id = intval($pvLibrary['alliance_id']);

                $allianceHour = AllianceHour::where('alliance_id', '=', $alliance_id)
                    ->where('time', '=', $time)
                    ->first();
                
                if(empty($allianceHour))
                {
                    $allianceHour = new AllianceHour;
                    $allianceHour->alliance_id = $alliance_id;
                    $allianceHour->time = $time;
                    $allianceHour->pv_number = $pv;
                }
                else
                {
                    $allianceHour->pv_number += $pv;
                }

                $allianceHour->save();
            }
            //---------------------------联盟数据------------------------



            echo date("m-d H:i:s") . " PV结算位置：".$time."\n";
            usleep(5000); //0.005秒
        }
        //------------------------------------------------PV结算处理------------------------------------------------



    }

    //PV统计每小时处理一次
    public static function EarningHour()
    {
        die;
        startHour:

        //结算
        $hour_time = date('Y-m-d H').":00:00";
        $earningMinute = EarningMinute::where('statev', '=', '1')->where('time', '<', $hour_time)->orderBy('id', 'asc')->offset(0)->limit(5)->get();
        
        if( count($earningMinute) > 0 )
        {
            foreach($earningMinute as $key=>$val)
            {
                EarningMinute::where('id', '=', $val->id)->update(['statev'=>2]);


                $this_time = substr($val->time, 0, -6).':00:00';

                //EarningHour 查找
                $earningHour = EarningHour::where('webmaster_id', '=', $val->webmaster_id)
                    ->where('myads_id', '=', $val->myads_id)
                    ->where('time', '=', $this_time)
                    ->first();
                
                //没有则添加
                if(empty($earningHour))
                {
                    $earningHour = new EarningHour;
                    
                    $earningHour->webmaster_id = $val->webmaster_id;
                    $earningHour->position_id = $val->position_id;
                    $earningHour->myads_id = $val->myads_id;
                    $earningHour->pv = $val->pv;
                    $earningHour->time = $this_time;
                }
                else
                {
                    $earningHour->pv = $earningHour->pv + $val->pv;
                }

                $earningHour->save();

                //修改状态
                EarningMinute::where('id', '=', $val->id)->update(['statev'=>4]);

            }

            echo date("m-d H:i:s") . " PV小时报表结算位置：".$val->created_at."\n";

            goto startHour;
        }

    }

    //PV统计每天处理一次
    public static function EarningDay()
    {
        startDay:

        //结算
        $day_time = date('Y-m-d')." 00:00:00";
        $earningHour = EarningHour::where('statev', '=', '1')->where('time', '<', $day_time)->orderBy('id', 'asc')->offset(0)->limit(5)->get();
        
        if( count($earningHour) > 0 )
        {
            foreach($earningHour as $key=>$val)
            {
                EarningHour::where('id', '=', $val->id)->update(['statev'=>2]);

                $this_time = substr($val->time, 0, -9).' 00:00:00';

                //EarningHour 查找
                $earningDay = EarningDay::where('webmaster_id', '=', $val->webmaster_id)
                    ->where('myads_id', '=', $val->myads_id)
                    ->where('time', '=', $this_time)
                    ->first();
                
                //没有则添加
                if(empty($earningDay))
                {
                    $earningDay = new EarningDay;
                    
                    $earningDay->webmaster_id = $val->webmaster_id;
                    $earningDay->position_id = $val->position_id;
                    $earningDay->myads_id = $val->myads_id;
                    $earningDay->pv = $val->pv;
                    $earningDay->time = $this_time;
                }
                else
                {
                    $earningDay->pv = $earningDay->pv + $val->pv;
                }

                $earningDay->save();

                //修改状态
                EarningHour::where('id', '=', $val->id)->update(['statev'=>4]);

            }

            echo date("m-d H:i:s") . " PV每天报表结算位置：".$val->created_at."\n";

            sleep(2);

            goto startDay;
        }
        
    }
}