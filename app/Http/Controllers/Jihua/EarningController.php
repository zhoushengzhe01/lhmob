<?php
namespace App\Http\Controllers\Jihua;

use Illuminate\Support\Facades\Redis;
use Illuminate\Routing\Controller as BaseController;

use App\Model\EarningClick;
use App\Model\EarningHour;
use App\Model\EarningDay;
use App\Model\Alliance;
use App\Model\AllianceHour;
use App\Model\AllianceFlux;
use App\Model\AllianceFluxExpendDay;
use App\Model\AllianceFluxExpendHour;
use App\Model\Webmaster;
use App\Model\WebmasterAds;
use App\Model\WebmasterMoneyLog;
use App\Model\Advertiser;
use App\Model\AdvertiserAds;
use App\Model\AdvertiserExpendHour;
use App\Model\AdvertiserExpendDay;

//计划脚本
class EarningController extends BaseController
{
    //10分钟一次
    public static function EarningHour()
    {
        self::EarningClickHour();

        self::EarningPvHour();

        //小时
        self::EarningDay();
    }

    //一小时一次
    public static function EarningDay()
    {
       
        if( intval(date('i')) >= 0 && intval(date('i')) < 10 )  //没小时0分-10分之间
        {
            self::EarningWebmasterDay();
        
            self::EarningAdvertiserDay();

            self::AllianceFluxEarningDay();

        }

        if( intval(date('H')) == 0 && intval(date('i')) >= 0 && intval(date('i')) < 10 )    //00点0分-00点10分之间
        {
            self::EarningDaySaveBalance();

            self::clearDate();
        }

        die('完成');
    }

    //点击统计
    public static function EarningClickHour()
    {

        startClick:

        $click = EarningClick::where('state', '=', '1')->orderBy('id', 'asc')->first();

        if(!empty($click))
        {
            //广告主(自家广告自家流量)
            if($click->type=='1' && !empty($click->advertiser_id))
            {
                startAdvertiser:

                $advertiser = Advertiser::where('id', '=', $click->advertiser_id)->first();

                $advertiserAd = AdvertiserAds::where('id', '=', $click->advertiser_ad_id)->first();

                $webmasterAd = WebmasterAds::where('id', '=', $click->myads_id)->first();

                $earningClick = EarningClick::where('advertiser_id', '=', $click->advertiser_id)
                    ->where('advertiser_ad_id', '=', $click->advertiser_ad_id)
                    ->where('myads_id', '=', $click->myads_id)
                    ->where('state', '=', '1')
                    ->where('type', '=', $click->type)
                    ->where('created_at', '>=', substr($click->created_at, 0, 10).' 00:00:00')
                    ->where('created_at', '<=', substr($click->created_at, 0, 10).' 23:59:59')
                    ->offset(0)->limit(50)
                    ->get()
                    ->toArray();
                
                if(!empty($earningClick))
                {
                    //默认数据
                    $data = [
                        'click'=>0,
                        'money'=>0,
                        'out_money'=>0,
                    ];

                    $update = EarningClick::where('id', '=', 0);

                    foreach($earningClick as $key=>$val)
                    {
                        $update = $update->orWhere(['id'=>$val['id']]);

                        $data['click'] += 1;
                        $data['money'] += round($advertiserAd->in_price * intval($webmasterAd->in_advertiser_price)/100/1000, 4);
                        $data['out_money'] += round($advertiserAd->out_price * intval($webmasterAd->out_advertiser_price)/100/1000, 4);
                    }
                    $update->update(['state'=>2]);

                    //更新广告主
                    $advertiser->money = $advertiser->money - $data['money'];
                    $advertiser->save();

                    //更新广告主广告
                    if($advertiserAd->expend_day_date!=substr($click->created_at, 0, 10))
                    {   
                        $advertiserAd->expend_day_date = substr($click->created_at, 0, 10);
                        $advertiserAd->expend_day = $data['money'];
                    }
                    else
                    {
                        $advertiserAd->expend_day += $data['money'];
                    }

                    if($advertiser->money < 1)
                    {
                        $advertiserAd->state = '2';
                    }

                    $advertiserAd->expend += $data['money'];
                    $advertiserAd->save();
                    
                    //广告主收益小时数据
                    $expendHour = AdvertiserExpendHour::where('advertiser_id', '=', $click->advertiser_id)
                        ->where('ads_id', '=', $click->advertiser_ad_id)
                        ->where('time', '=', substr($click->created_at, 0, 13).':00:00')
                        ->first();
                    
                    if(empty($expendHour))
                    {
                        $expendHour = new AdvertiserExpendHour;
                        $expendHour->advertiser_id = $click->advertiser_id;
                        $expendHour->ads_id = $click->advertiser_ad_id;
                        $expendHour->click_number = $data['click'];
                        $expendHour->money = $data['money'];
                        $expendHour->out_money = $data['out_money'];
                        $expendHour->time = substr($click->created_at, 0, 13).':00:00';
                    }
                    else
                    {
                        $expendHour->click_number += $data['click'];
                        $expendHour->money += $data['money'];
                        $expendHour->out_money += $data['out_money'];
                    }
                    $expendHour->save();

                    //站长
                    $earningHour = EarningHour::where('webmaster_id', '=', $click->webmaster_id)
                        ->where('position_id', '=', $click->position_id)
                        ->where('myads_id', '=', $click->myads_id)
                        ->where('time', '=', substr($click->created_at, 0, 13).':00:00')
                        ->first();

                    if(empty($earningHour))
                    {
                        $earningHour = new EarningHour;
                        $earningHour->webmaster_id = $click->webmaster_id;
                        $earningHour->position_id = $click->position_id;
                        $earningHour->myads_id = $click->myads_id;
                        $earningHour->time = substr($click->created_at, 0, 13).':00:00';
                        $earningHour->click = $data['click'];
                        $earningHour->money = $data['out_money'];
                    }
                    else
                    {
                        $earningHour->click += $data['click'];
                        $earningHour->money += $data['out_money'];
                    }

                    $earningHour->save();

                    $update->update(['state'=>4]);

                    echo date("m-d H:i:s") . " 结算广告主：". $click->created_at ."\n";
                    
                    goto startAdvertiser;
                }

            }

            //联盟（联盟广告自家流量）
            if($click->type=='2' && !empty($click->alliance_id))
            {
                $alliance = Alliance::where('id', '=', $click->alliance_id)->first(['price']);

                $webmasterAd = WebmasterAds::where('id', '=', $click->myads_id)->first(['out_alliance_price']);

                startWebmaster:

                $earningClick = EarningClick::where('alliance_id', '=', $click->alliance_id)
                    ->where('myads_id', '=', $click->myads_id)
                    ->where('type', '=', $click->type)
                    ->where('state', '=', '1')
                    ->where('created_at', '>=', substr($click->created_at, 0, 10).' 00:00:00')
                    ->where('created_at', '<=', substr($click->created_at, 0, 10).' 23:59:59')
                    ->offset(0)->limit(50)
                    ->get(['id', 'alliance_id', 'myads_id'])
                    ->toArray();
            
                if(!empty($earningClick))
                {
                    //默认数据
                    $data = [
                        'click'=>0,
                        'money'=>0,
                    ];

                    $update = EarningClick::where('id', '=', '0');

                    foreach($earningClick as $key=>$val)
                    {
                        $update = $update->orWhere(['id'=>$val['id']]);

                        $data['click'] += 1;
                        $data['money'] += round($alliance->price * intval($webmasterAd->out_alliance_price)/100/1000, 4);
                    }
                    
                    $update->update(['state'=>'2']);

                    $allianceHour = AllianceHour::where('alliance_id', '=', $click->alliance_id)
                        ->where('time', '=', substr($click->created_at, 0, 13).':00:00')
                        ->first();

                    if(empty($allianceHour))
                    {
                        $allianceHour = new AllianceHour;
                        $allianceHour->alliance_id = $click->alliance_id;
                        $allianceHour->click_number = $data['click'];
                        $allianceHour->expend = $data['money'];
                        $allianceHour->time = substr($click->created_at, 0, 13).':00:00';
                    }
                    else
                    {
                        $allianceHour->click_number += $data['click'];
                        $allianceHour->expend += $data['money'];
                    }
                    $allianceHour->save();


                    //站长
                    $earningHour = EarningHour::where('webmaster_id', '=', $click->webmaster_id)
                        ->where('position_id', '=', $click->position_id)
                        ->where('myads_id', '=', $click->myads_id)
                        ->where('time', '=', substr($click->created_at, 0, 13).':00:00')
                        ->first();
                    
                    if(empty($earningHour))
                    {
                        $earningHour = new EarningHour;
                        $earningHour->webmaster_id = $click->webmaster_id;
                        $earningHour->position_id = $click->position_id;
                        $earningHour->myads_id = $click->myads_id;
                        $earningHour->time = substr($click->created_at, 0, 13).':00:00';
                        $earningHour->click = $data['click'];
                        $earningHour->money = $data['money'];
                    }
                    else
                    {
                        $earningHour->click += $data['click'];
                        $earningHour->money += $data['money'];
                    }
                    $earningHour->save();

                    $update->update(['state'=>'4']);

                    echo date("m-d H:i:s") . " 结算联盟：". $click->created_at ."\n";

                    goto startWebmaster;

                }
            }
 
            //联盟流量（自家广告联盟流量）
            if($click->type=='3' && !empty($click->advertiser_id))
            {
                startAllianceFlux:

                $advertiser = Advertiser::where('id', '=', $click->advertiser_id)->first();

                $advertiserAd = AdvertiserAds::where('id', '=', $click->advertiser_ad_id)->first();
          
                $allianceFlux = AllianceFlux::where('id', '=', $click->alliance_flux_id)->first();

                $earningClick = EarningClick::where('advertiser_id', '=', $click->advertiser_id)
                    ->where('advertiser_ad_id', '=', $click->advertiser_ad_id)
                    ->where('alliance_flux_id', '=', $click->alliance_flux_id)
                    ->where('state', '=', '1')
                    ->where('type', '=', $click->type)
                    ->where('created_at', '>=', substr($click->created_at, 0, 10).' 00:00:00')
                    ->where('created_at', '<=', substr($click->created_at, 0, 10).' 23:59:59')
                    ->offset(0)->limit(50)
                    ->get()
                    ->toArray();
                
                if(!empty($earningClick))
                {
                    //默认数据
                    $data = [
                        'click'=>0,
                        'pv_number'=>0,
                        'in_money'=>0,
                        'out_money'=>0,
                    ];

                    $update = EarningClick::where('id', '=', 0);
                    
                    foreach($earningClick as $key=>$val)
                    {
                        $update = $update->orWhere(['id'=>$val['id']]);

                        $data['click'] += 1;
                        $data['pv_number'] += 4;
                        $data['in_money'] += round($advertiserAd->in_price * intval($allianceFlux->in_price_ratio)/100/1000, 4);
                        $data['out_money'] += round($advertiserAd->out_price * intval($allianceFlux->out_price_ratio)/100/1000, 4);
                    }
                    $update->update(['state'=>2]);

                    //更新广告主
                    $advertiser->money = $advertiser->money - $data['in_money'];
                    $advertiser->save();

                    //更新广告主广告
                    if($advertiserAd->expend_day_date!=substr($click->created_at, 0, 10))
                    {   
                        $advertiserAd->expend_day_date = substr($click->created_at, 0, 10);
                        $advertiserAd->expend_day = $data['in_money'];
                    }
                    else
                    {
                        $advertiserAd->expend_day += $data['in_money'];
                    }

                    if($advertiser->money < 1)
                    {
                        $advertiserAd->state = '2';
                    }

                    $advertiserAd->expend += $data['in_money'];
                    $advertiserAd->save();
                    
                    //广告主收益小时数据
                    $expendHour = AdvertiserExpendHour::where('advertiser_id', '=', $click->advertiser_id)
                        ->where('ads_id', '=', $click->advertiser_ad_id)
                        ->where('time', '=', substr($click->created_at, 0, 13).':00:00')
                        ->first();
                    
                    if(empty($expendHour))
                    {
                        $expendHour = new AdvertiserExpendHour;
                        $expendHour->advertiser_id = $click->advertiser_id;
                        $expendHour->ads_id = $click->advertiser_ad_id;
                        $expendHour->pv_number = $data['pv_number'];
                        $expendHour->click_number = $data['click'];
                        $expendHour->money = $data['in_money'];
                        $expendHour->out_money = $data['out_money'];
                        $expendHour->time = substr($click->created_at, 0, 13).':00:00';
                    }
                    else
                    {
                        $expendHour->pv_number += $data['pv_number'];
                        $expendHour->click_number += $data['click'];
                        $expendHour->money += $data['in_money'];
                        $expendHour->out_money += $data['out_money'];
                    }
                    $expendHour->save();

                    //统计到广告主流量
                    $expendHour = AllianceFluxExpendHour::where('alliance_flux_id', '=', $click->alliance_flux_id)
                        ->where('adstype_id', '=', $click->position_id)
                        ->where('time', '=', substr($click->created_at, 0, 13).':00:00')
                        ->first();

                    if(empty($expendHour))
                    {
                        $expendHour = new AllianceFluxExpendHour;
                        $expendHour->alliance_flux_id = $click->alliance_flux_id;
                        $expendHour->adstype_id = $click->position_id;
                        $expendHour->time = substr($click->created_at, 0, 13).':00:00';
                        $expendHour->pv_number = $data['pv_number'];
                        $expendHour->click_number = $data['click'];
                        $expendHour->in_money = $data['in_money'];
                        $expendHour->out_money = $data['out_money'];
                    }
                    else
                    {
                        $expendHour->pv_number += $data['pv_number'];
                        $expendHour->click_number += $data['click'];
                        $expendHour->in_money += $data['in_money'];
                        $expendHour->out_money += $data['out_money'];
                    }

                    $expendHour->save();

                    $update->update(['state'=>4]);

                    echo date("m-d H:i:s") . " 结算联盟流量：". $click->created_at ."\n";
                
                    goto startAllianceFlux;
                }
            }

            echo date("m-d H:i:s") . " 结算一个类型：". $click->created_at ."\n";

            goto startClick;
        }
    }

    //展示统计
    public static function EarningPvHour()
    {
        //数据在redis
        while ( $pointer = Redis::rpop("new_pv_pointer") ) 
        {
            //获取
            $library = json_decode(Redis::hget("new_pv_library", $pointer), true);

            //删除
            Redis::hdel("new_pv_library", $pointer);

            //站长
            if($library['type']=='0')
            {
                $earningHour = EarningHour::where('webmaster_id', '=', $library['webmaster_id'])
                    ->where('position_id', '=', $library['position_id'])
                    ->where('myads_id', '=', $library['myads_id'])
                    ->where('time', '=', $library['time'].":00:00")
                    ->first();

                if(empty($earningHour))
                {
                    $earningHour = new EarningHour;
                    $earningHour->webmaster_id = $library['webmaster_id'];
                    $earningHour->position_id = $library['position_id'];
                    $earningHour->myads_id = $library['myads_id'];
                    $earningHour->time = $library['time'].':00:00';
                    $earningHour->pv = intval($library['pv']) * 5;
                    $earningHour->ip = intval($library['ip']);
                }
                else
                {
                    $earningHour->pv += intval($library['pv']) * 5;
                    $earningHour->ip += intval($library['ip']);
                }

                $earningHour->save();
            }
            
            //广告主
            if($library['type']=='1')
            {
                $expendHour = AdvertiserExpendHour::where('advertiser_id', '=', $library['advertiser_id'])
                    ->where('ads_id', '=', $library['advertiser_ad_id'])
                    ->where('time', '=', $library['time'].":00:00")
                    ->first();

                if(empty($expendHour))
                {
                    $expendHour = new AdvertiserExpendHour;
                    $expendHour->advertiser_id = $library['advertiser_id'];
                    $expendHour->ads_id = $library['advertiser_ad_id'];
                    $expendHour->time = $library['time'].':00:00';
                    $expendHour->pv_number = intval($library['pv']) * 5;
                    $expendHour->ip_number = intval($library['ip']);
                }
                else
                {
                    $expendHour->pv_number += intval($library['pv']) * 5;
                    $expendHour->ip_number += intval($library['ip']);
                }

                $expendHour->save();
            }
            
            //联盟
            if($library['type']=='2')
            {
                $allianceHour = AllianceHour::where('alliance_id', '=', $library['alliance_id'])
                    ->where('time', '=', $library['time'].":00:00")
                    ->first();
                
                if(empty($allianceHour))
                {
                    $allianceHour = new AllianceHour;
                    $allianceHour->alliance_id = $library['alliance_id'];
                    $allianceHour->time = $library['time'];
                    $allianceHour->pv_number = intval($library['pv']) * 5;
                }
                else
                {
                    $allianceHour->pv_number += intval($library['pv']) * 5;
                }

                $allianceHour->save();
            }

            echo date("m-d H:i:s") . " PV结算位置：".$library['time']."\n";

            usleep(5000); //0.005秒
        }
    }

    //站长
    public static function EarningWebmasterDay()
    {
        startWebmaster:
        
        $earningHour = EarningHour::where('statev', '=', '1')->where('time', '<', date('Y-m-d H').':00:00')->orderBy('id', 'asc')->offset(0)->limit(5)->get()->toArray();

        if(!empty($earningHour))
        {
            foreach($earningHour as $key=>$val)
            {
                
                EarningHour::where('id', '=', $val['id'])->update(['statev'=>2]);

                $date = substr($val['time'], 0, 10);

                $earningDay = EarningDay::where('webmaster_id', '=', $val['webmaster_id'])
                    ->where('position_id', '=', $val['position_id'])
                    ->where('myads_id', '=', $val['myads_id'])
                    ->where('date', '=', $date)
                    ->first();
                
                //没有则添加
                if(empty($earningDay))
                {
                    $earningDay = new EarningDay;
                    $earningDay->webmaster_id = $val['webmaster_id'];
                    $earningDay->position_id = $val['position_id'];
                    $earningDay->myads_id = $val['myads_id'];

                    $earningDay->time = $date." 00:00:00";
                    $earningDay->date = $date;
                    $earningDay->click = $val['click'];
                    $earningDay->money = $val['money'];
                    $earningDay->ip = $val['ip'];
                    $earningDay->uv = $val['uv'];
                    $earningDay->pv = $val['pv'];
                }
                else
                {
                    $earningDay->click += $val['click'];
                    $earningDay->money += $val['money'];
                    $earningDay->ip += $val['ip'];
                    $earningDay->uv += $val['uv'];
                    $earningDay->pv += $val['pv'];
                }

                $earningDay->save();

                //更新到广告表里的今天收益
                $webmasterAds = WebmasterAds::where('id', '=', $val['myads_id'])->first();
                if(!empty($webmasterAds))
                {
                    $webmasterAds->earning_day = $earningDay->money;
                    $webmasterAds->save();
                }

                EarningHour::where('id', '=', $val['id'])->update(['statev'=>4]);
            }

            echo date("m-d H:i:s") . " 站长每天结算位置：".$val['time']."\n";

            sleep(1);

            goto startWebmaster;
        }
    }

    //联盟
    public static function EarningAdvertiserDay()
    {
        startAdvertiser:
        
        $expendHour = AdvertiserExpendHour::where('state', '=', '1')->where('time', '<', date('Y-m-d H').':00:00')->orderBy('id', 'asc')->offset(0)->limit(5)->get()->toArray();

        if(!empty($expendHour))
        {
            foreach($expendHour as $key=>$val)
            {
                AdvertiserExpendHour::where('id', '=', $val['id'])->update(['state'=>2]);

                $date = substr($val['time'], 0, 10);

                $expendDay = AdvertiserExpendDay::where('advertiser_id', '=', $val['advertiser_id'])
                    ->where('ads_id', '=', $val['ads_id'])
                    ->where('date', '=', $date)
                    ->first();
                
                //没有则添加
                if(empty($expendDay))
                {
                    $expendDay = new AdvertiserExpendDay;
        
                    $expendDay->advertiser_id = $val['advertiser_id'];
                    $expendDay->ads_id = $val['ads_id'];
                    $expendDay->pv_number = $val['pv_number'];
                    $expendDay->ip_number = $val['ip_number'];
                    $expendDay->click_number = $val['click_number'];
                    $expendDay->money = $val['money'];
                    $expendDay->out_money = $val['out_money'];
                    $expendDay->date = $date;
                }
                else
                {
                    $expendDay->pv_number += $val['pv_number'];
                    $expendDay->ip_number += $val['ip_number'];
                    $expendDay->click_number += $val['click_number'];
                    $expendDay->money += $val['money'];
                    $expendDay->out_money += $val['out_money'];
                }

                $expendDay->save();

                AdvertiserExpendHour::where('id', '=', $val['id'])->update(['state'=>4]);
            }
        
            echo date("m-d H:i:s") . " 广告主每天结算位置：".$val['time']."\n";

            sleep(1);

            goto startAdvertiser;
        }
    }



    //联盟流量
    public static function AllianceFluxEarningDay()
    {
        startAllianceFluxEarningDay:
        
        $expendHour = AllianceFluxExpendHour::where('state', '=', '1')->where('time', '<', date('Y-m-d H').':00:00')->orderBy('id', 'asc')->offset(0)->limit(5)->get()->toArray();

        if(!empty($expendHour))
        {
            foreach($expendHour as $key=>$val)
            {
                AllianceFluxExpendHour::where('id', '=', $val['id'])->update(['state'=>2]);

                $date = substr($val['time'], 0, 10);

                $expendDay = AllianceFluxExpendDay::where('alliance_flux_id', '=', $val['alliance_flux_id'])
                    ->where('adstype_id', '=', $val['adstype_id'])
                    ->where('date', '=', $date)
                    ->first();
                
                //没有则添加
                if(empty($expendDay))
                {
                    $expendDay = new AllianceFluxExpendDay;

                    $expendDay->alliance_flux_id = $val['alliance_flux_id'];
                    $expendDay->adstype_id = $val['adstype_id'];
                    $expendDay->pv_number = $val['pv_number'];
                    $expendDay->click_number = $val['click_number'];
                    $expendDay->in_money = $val['in_money'];
                    $expendDay->out_money = $val['out_money'];
                    $expendDay->date = $date;
                }
                else
                {
                    $expendDay->pv_number += $val['pv_number'];
                    $expendDay->click_number += $val['click_number'];
                    $expendDay->in_money += $val['in_money'];
                    $expendDay->out_money += $val['out_money'];
                }

                $expendDay->save();

                AllianceFluxExpendHour::where('id', '=', $val['id'])->update(['state'=>4]);
            }
        
            echo date("m-d H:i:s") . " 联盟流量每天结算位置：".$val['time']."\n";

            sleep(1);

            goto startAllianceFluxEarningDay;
            
        }
    }

    //每天数据存入账户余额-站长
    public static function EarningDaySaveBalance()
    {
        startWebmasterSaveBalance:

        $earningDay = EarningDay::where('statec', '=', '1')->where('date', '<', date('Y-m-d'))->orderBy('id', 'asc')->offset(0)->limit(10)->get()->toArray();
   
        if(!empty($earningDay))
        {
            foreach($earningDay as $key=>$val)
            {
                EarningDay::where('id', '=', $val['id'])->update(['statec'=>2]);

                $webmaster = Webmaster::where('id', '=', $val['webmaster_id'])->first();
               
                if(!empty($webmaster))
                {
                    $webmaster->money += $val['money'];
                    
                    $webmaster->save();

                    //插入余额变动记录
                    $moneylog = new WebmasterMoneyLog;
                    $moneylog->webmaster_id = $val['webmaster_id'];
                    $moneylog->money = $val['money'];
                    $moneylog->message = '收益结算';
                    $moneylog->save();

                    EarningDay::where('id', '=', $val['id'])->update(['statec'=>4]);
                }
            }

            echo date("m-d H:i:s") . " 每天钱结算账户余额：".$val['date']."\n";

            sleep(1);

            goto startWebmasterSaveBalance;
        }

    }

    //数据清除
    public static function clearDate()
    {
        //点击的保留三天
        EarningClick::where('state', '=', '4')->where('created_at', '<', date("Y-m-d",strtotime("-3 day")).' 00:00:00')->delete();

        //保留30天的
        EarningHour::where('statev', '=', '4')->where('created_at', '<', date("Y-m-d",strtotime("-30 day")).' 00:00:00')->delete();

        //保留30天的
        //AllianceHour::where('statev', '=', '4')->where('created_at', '<', date("Y-m-d",strtotime("-30 day")).' 00:00:00')->delete();

        //保留30天的
        AllianceFluxExpendHour::where('state', '=', '4')->where('created_at', '<', date("Y-m-d",strtotime("-30 day")).' 00:00:00')->delete();

        //保留30天的
        AdvertiserExpendHour::where('state', '=', '4')->where('created_at', '<', date("Y-m-d",strtotime("-30 day")).' 00:00:00')->delete();

        //清空今天消耗，今天收益
        WebmasterAds::where('id', '<>', 0)->update(['earning_day'=>0]);
        AdvertiserAds::where('id', '<>', 0)->update(['expend_day'=>0]);
    }
}