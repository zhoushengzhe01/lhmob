<?php
namespace App\Http\Controllers\Jihua;

use Illuminate\Routing\Controller as BaseController;

use App\Model\EarningClick;
use App\Model\EarningPv;
use App\Model\EarningMinute;
use App\Model\EarningHour;
use App\Model\EarningDay;
use App\Model\WebmasterAds;
use App\Model\WebmasterMoneyLog;
use App\Model\Alliance;
use App\Model\Webmaster;
use App\Model\AllianceHour;



class EarningClickController extends BaseController
{
    //点击统计10分钟处理一次
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
        $click = EarningClick::where('state', '=', '1')->orderBy('id', 'asc')->offset(0)->limit(100)->get();
        
        if( count($click)>0 )
        {
            
            foreach($click as $key=>$val)
            {
                /**
                 * 处理数据开始
                 */
                EarningClick::where('id', '=', $val->id)->update(['state'=>2]);

                $this_time = substr($val->created_at, 0, -4).'0:00';

                //EarningMinute 查找
                $earningMinute = EarningMinute::where('webmaster_id', '=', $val->webmaster_id)
                    ->where('myads_id', '=', $val->myads_id)
                    ->where('time', '=', $this_time)
                    ->first();
                
                //查找广告位置
                $webmasterAds = WebmasterAds::where('id', '=', $val->myads_id)->first();
                if(!empty($webmasterAds->price))
                {
                    $money = sprintf("%.3f", ($alliance[$val->alliance_id]->price * $webmasterAds->price)/1000/100);
                }
                else
                {
                    $money = sprintf("%.3f", $alliance[$val->alliance_id]->price * 1 /1000);
                }
                
                $webmasterAds->is_top = 1;
                $webmasterAds->save();
                
                //没有则添加
                if(empty($earningMinute))
                {
                    $earningMinute = new EarningMinute;
                    
                    $earningMinute->webmaster_id = $val->webmaster_id;
                    $earningMinute->position_id = $val->position_id;
                    $earningMinute->myads_id = $val->myads_id;
                    $earningMinute->click = 1;
                    $earningMinute->money = $money;
                    $earningMinute->ip = 1;
                    $earningMinute->time = $this_time;
                }
                else
                {
                    $earningMinute->click = $earningMinute->click + 1;
                    $earningMinute->money = $earningMinute->money + $money;
                    if($val->ipis_repeat=='0')
                    {
                        $earningMinute->ip = $earningMinute->ip + 1;
                    }
                    
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
                    $allianceHour->click_number = 1;
                    $allianceHour->expend = $money;
                    $allianceHour->time = $this_time;
                }
                else
                {
                    $allianceHour->click_number = $allianceHour->click_number + 1;
                    $allianceHour->expend = $allianceHour->expend + $money;
                }

                $allianceHour->save();

                /**
                 * 处理数据截止
                 */
                EarningClick::where('id', '=', $val->id)->update(['state'=>4]);

            }
            
            echo date("m-d H:i:s") . " 点击结算位置：".$val->created_at."\n";
            
            sleep(1);

            goto start;

        }

    }

    //点击统计一个小时处理一次
    public static function EarningHour()
    {
        startHour:

        //结算
        $hour_time = date('Y-m-d H').":00:00";
        $earningMinute = EarningMinute::where('statec', '=', '1')->where('time', '<', $hour_time)->orderBy('id', 'asc')->offset(0)->limit(10)->get();
        
        if( count($earningMinute) > 0 )
        {
            foreach($earningMinute as $key=>$val)
            {
                EarningMinute::where('id', '=', $val->id)->update(['statec'=>2]);


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
                    $earningHour->click = $val->click;
                    $earningHour->money = $val->money;
                    $earningHour->ip = $val->ip;
                    $earningHour->time = $this_time;
                }
                else
                {
                    $earningHour->click = $earningHour->click + $val->click;
                    $earningHour->money = $earningHour->money + $val->money;
                    $earningHour->ip = $earningHour->ip + $val->ip;
                }

                $earningHour->save();

                //修改状态
                EarningMinute::where('id', '=', $val->id)->update(['statec'=>4]);

            }

            echo date("m-d H:i:s") . " 点击小时报表结算位置：".$val->created_at."\n";

            goto startHour;
        }


        /**
         * 定在每小时删除一次数据
         */

        self::delData();

        /**
         * 定在每小时删除一次数据
         */

    }

    //点击统计一天处理一次
    public static function EarningDay()
    {
        startDay:

        //结算
        $day_time = date('Y-m-d')." 00:00:00";
        $earningHour = EarningHour::where('statec', '=', '1')->where('time', '<', $day_time)->orderBy('id', 'asc')->offset(0)->limit(24)->get();
        
        if( count($earningHour) > 0 )
        {
            foreach($earningHour as $key=>$val)
            {
                EarningHour::where('id', '=', $val->id)->update(['statec'=>2]);


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
                    $earningDay->click = $val->click;
                    $earningDay->money = $val->money;
                    $earningDay->ip = $val->ip;
                    $earningDay->time = $this_time;
                }
                else
                {
                    $earningDay->click = $earningDay->click + $val->click;
                    $earningDay->money = $earningDay->money + $val->money;
                    $earningDay->ip = $earningDay->ip + $val->ip;
                }

                $earningDay->save();

                //修改状态
                EarningHour::where('id', '=', $val->id)->update(['statec'=>4]);
            }

            echo date("m-d H:i:s") . " 点击每天报表结算位置：".$val->created_at."\n";

            sleep(2);

            goto startDay;
        }
        else
        {
            //每天的处理完成之后 , 往账户
            $day_time = date('Y-m-d')." 00:00:00";
            $earningDay = EarningDay::where('statec', '=', '1')->where('time', '<', $day_time)->orderBy('id', 'asc')->get();

            foreach($earningDay as $key=>$val)
            {
                //修改状态
                EarningDay::where('id', '=', $val->id)->update(['statec'=>2]);

                $webmaster = Webmaster::where('id', '=', $val->webmaster_id)->first();
                $webmaster->money += $val->money;

                if($webmaster->save())
                {
                    $webmasterMoneyLog = new WebmasterMoneyLog;
                    $webmasterMoneyLog->webmaster_id = $val->webmaster_id;
                    $webmasterMoneyLog->money = $val->money;
                    $webmasterMoneyLog->message = $val->time." 点击结算";

                    $webmasterMoneyLog->save();
                }

                //修改状态
                EarningDay::where('id', '=', $val->id)->update(['statec'=>4]);
            }
        }

    }


    /***
     * pv 数据删除
     * 
     * earning_click表 删除7天前已经处理过的数据
     * 
     * earning_pv表 删除已经处理过
     * 
     * earning_minute  删除1天前已经处理过的数据
     * 
     * earning_hour 删除7天前已经处理过的数据
     * 
     * earning_day 删除60天前已经处理过的数据
     */
    public static function delData()
    {
        //earning_pv表 删除已经处理过
        EarningPv::where('state', '=', '4')->where('state', '=', '4')->delete();

        //earning_click  删除7天前已经处理过的数据
        $time = date("Y-m-d",strtotime("-7 day")).' 00:00:00';
        EarningClick::where('state', '=', '4')->where('created_at', '<', $time)->delete();

        //earning_minute  删除1天前已经处理过的数据
        $time = date("Y-m-d",strtotime("-1 day")).' 00:00:00';
        EarningMinute::where('statec', '=', '4')->where('statev', '=', '4')->where('created_at', '<', $time)->delete();

        //earning_hour 删除7天前已经处理过的数据
        $time = date("Y-m-d",strtotime("-7 day")).' 00:00:00';
        EarningHour::where('statec', '=', '4')->where('statev', '=', '4')->where('created_at', '<', $time)->delete();

        //earning_hour 删除60天前已经处理过的数据
        //$time = date("Y-m-d",strtotime("-60 day")).' 00:00:00';
        //EarningDay::where('statec', '=', '4')->where('statev', '=', '4')->where('time', '<', $time)->delete();

    }
}