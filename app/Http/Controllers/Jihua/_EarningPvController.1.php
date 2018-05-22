<?php
namespace App\Http\Controllers\Jihua;

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
        //联盟
        $allianceArr = Alliance::where('state', '=', '1')->get();
        $alliance = [];
        foreach($allianceArr as $key=>$val)
        {
            $alliance[$val->id] = $val;
        }

        start:
            
        //结算
        $pv = EarningPv::where('state', '=', '1')->orderBy('id', 'asc')->offset(0)->limit(50)->get();
        
        if( count($pv)>0 )
        {
            
            foreach($pv as $key=>$val)
            {
                EarningPv::where('id', '=', $val->id)->update(['state'=>2]);


                $this_time = substr($val->created_at, 0, -4).'0:00';

                //EarningMinute 查找
                $earningMinute = EarningMinute::where('webmaster_id', '=', $val->webmaster_id)
                    ->where('myads_id', '=', $val->myads_id)
                    ->where('time', '=', $this_time)
                    ->first();
                    
                //没有则添加
                if(empty($earningMinute))
                {
                    $earningMinute = new EarningMinute;
                    
                    $earningMinute->webmaster_id = $val->webmaster_id;
                    $earningMinute->position_id = $val->position_id;
                    $earningMinute->myads_id = $val->myads_id;
                    $earningMinute->pv = 5;
                    $earningMinute->time = $this_time;
                }
                else
                {
                    $earningMinute->pv = $earningMinute->pv + 5;
                }

                $earningMinute->save();


                //AllianceHour 
                $this_time = substr($val->created_at, 0, -6).':00:00';

                $allianceHour = AllianceHour::where('alliance_id', '=', $val->alliance_id)
                    ->where('time', '=', $this_time)
                    ->first();
                
                if(empty($allianceHour))
                {
                    $allianceHour = new AllianceHour;
                    $allianceHour->alliance_id = $val->alliance_id;
                    $allianceHour->pv_number = 5;
                    $allianceHour->time = $this_time;
                }
                else
                {
                    $allianceHour->pv_number = $allianceHour->pv_number + 5;
                }

                $allianceHour->save();

                //修改状态
                EarningPv::where('id', '=', $val->id)->update(['state'=>4]);

            }

            echo date("m-d H:i:s") . " PV结算位置：".$val->created_at."\n";

            sleep(1);

            goto start;

        }
    }

    //PV统计每小时处理一次
    public static function EarningHour()
    {
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