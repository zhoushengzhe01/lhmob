<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\Model\AdvertiserLoginLog;
use App\Model\Advertiser;
use App\Model\Users;
use App\Model\EarningHour;
use Hash;

class IndexController extends ApiController
{

    public function getWebmasterEarningHour(Request $request)
    {
        self::Admin();
        
        $present = $request->input();

        if(empty($present['date']))
        {
            $date = date('Y-m-d');
        }
        
        $default = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
        
        $result = EarningHour::where('time', '>=', $date.' 00:00:00')->where('time', '<=', $date.' 23:59:59')->orderBy('id', 'asc')->get(['money', 'click', 'pv', 'time']);

        $today = [];

        foreach($default as $key=>$val)
        {
            $data = ['money'=>0, 'click'=>0, 'pv'=>0];

            foreach($result as $k=>$v)
            {
                if(substr($v->time , 11, 2)==$val)
                {
                    $data['money'] += $v->money;
                    $data['click'] += $v->click;
                    $data['pv'] += $v->pv;
                    $data['time'] = $v->time;
                }
            }

            $today[] = $data;
        }

        
        $date = date("Y-m-d", strtotime("-1 day", strtotime($date)));

        $result = EarningHour::where('time', '>=', $date.' 00:00:00')->where('time', '<=', $date.' 23:59:59')->orderBy('id', 'asc')->get();

        $yesterday = [];

        foreach($default as $key=>$val)
        {
            $data = ['money'=>0, 'click'=>0, 'pv'=>0];

            foreach($result as $k=>$v)
            {
                if(substr($v->time , 11, 2)==$val)
                {
                    $data['money'] += $v->money;
                    $data['click'] += $v->click;
                    $data['pv'] += $v->pv;
                    $data['time'] = $v->time;
                }
            }

            $yesterday[] = $data;
        }

        $data = [
            'default'=>$default,
            'today'=>$today,
            'yesterday'=>$yesterday,
        ];

        return response()->json(['data'=>$data], 200);
    }
}
