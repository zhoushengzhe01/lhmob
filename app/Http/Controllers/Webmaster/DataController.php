<?php
namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Model\EarningDay;
use App\Model\EarningHour;


class DataController extends ApiController
{
    //获取
    public function getData(Request $request)
    {
        self::Webmaster();

        $defaultDate = $this->defaultDate(14);

        $myad_id = trim($request->input('myad_id'));

        $defaultDay = date('Y-m-d');
   
        //两周数据
        $weekEarnings = EarningDay::where('webmaster_id', '=', self::$user->id)
            ->where('date', '>=', $defaultDate[0]['date'])
            ->where('date', '<=', $defaultDate[13]['date']);

        if(!empty($myad_id))
            $weekEarnings = $weekEarnings->where('myads_id', '=', $myad_id);

        $weekEarnings = $weekEarnings->get(['pv', 'ip', 'click', 'money', 'date'])->toArray();

        //今天数据
        $dayEarnings = EarningHour::where('webmaster_id', '=', self::$user->id)
            ->where('time', '>=', $defaultDay.' 00:00:00')
            ->where('time', '<=', $defaultDay.' 23:59:59');

        if(!empty($myad_id))
            $dayEarnings = $dayEarnings->where('myads_id', '=', $myad_id);

        $dayEarnings = $dayEarnings->get(['pv', 'ip', 'click', 'money', 'time'])->toArray();


        //一周数据
        $weekEarnings = $this->groupWeekByDay($defaultDate, $weekEarnings);
        
        //今天数据
        $dayEarnings = $this->groupDayByDay($dayEarnings);

        //昨天数据
        $yesterday = $this->getYesterday($weekEarnings);
        

        //本周上周
        $week = $this->groupWeekByWeek($weekEarnings, $dayEarnings);
        
        $data = [
            'weekearnings' => $weekEarnings,
            'yesterday' => $yesterday,
            'dayearnings' => $dayEarnings,
            'week' => $week,
        ];

        return response()->json(['data'=>$data], 200);
    }

    //默认date
    public function defaultDate($number)
    {
        $week = (date("w")==0) ? 6 : (date("w")-1);

        $date = [];

        for($i=0 ; $i<$number ; $i++)
        {
            $key = $number-(7-$week)-$i;

            $date[$i]['date'] = date("Y-m-d",strtotime('-'.$key.' day'));
            if($i<7)
            {
                $date[$i]['week'] = 'last';
            }
            else
            {
                $date[$i]['week'] = 'this';
            }

        }

        return $date;
    }

    
    //获取昨天数据
    public function getYesterday($data)
    {
        $yesterday = [
            'pv_number'=> 0,
            'ip_number'=> 0,
            'click_number'=> 0,
            'money'=> 0,
        ];

        foreach($data as $k=>$v)
        {
            if($v['date']==date('Y-m-d', strtotime('-1 day')))
            {
                $yesterday['pv_number'] += $v['pv_number'];
                $yesterday['ip_number'] += $v['ip_number'];
                $yesterday['click_number'] += $v['click_number'];
                $yesterday['money'] += $v['money'];
            }
        }

        return $yesterday;
    }


    //汇总两周数据／天
    public function groupWeekByDay($default, $data)
    {   
        foreach($default as $key=>$val)
        {
            //初始化
            $val['pv_number'] = 0;
            $val['ip_number'] = 0;
            $val['click_number'] = 0;
            $val['money'] = 0;

            foreach($data as $k=>$v)
            {
                if($v['date']==$val['date'])
                {
                    $val['pv_number'] += $v['pv'];
                    $val['ip_number'] += $v['ip'];
                    $val['click_number'] += $v['click'];
                    $val['money'] += $v['money'];
                }

            }

            $default[$key] = $val;
        }
        return $default;
    }

    //汇总上周数据／
    public function groupWeekByWeek($weekExpends, $dayExpends)
    {
        //本周
        $lastWeek = [
            'pv_number'=> 0,
            'ip_number'=> 0,
            'click_number'=> 0,
            'money'=> 0,
        ];

        $thisWeek = [
            'pv_number'=> 0,
            'ip_number'=> 0,
            'click_number'=> 0,
            'money'=> 0,
        ];
        
        foreach($weekExpends as $key=>$val)
        {
            //上周
            if($val['week']=='last')
            {
               $lastWeek['pv_number'] += $val['pv_number'];
               $lastWeek['ip_number'] += $val['ip_number'];
               $lastWeek['click_number'] += $val['click_number'];
               $lastWeek['money'] += $val['money'];
            }

            //本周
            if($val['week']=='this')
            {
                $thisWeek['pv_number'] += $val['pv_number'];
                $thisWeek['ip_number'] += $val['ip_number'];
                $thisWeek['click_number'] += $val['click_number'];
                $thisWeek['money'] += $val['money'];
            }
        }

        //本周加今天的
        $thisWeek['pv_number'] += $dayExpends['pv_number'];
        $thisWeek['ip_number'] += $dayExpends['ip_number'];
        $thisWeek['click_number'] += $dayExpends['click_number'];
        $thisWeek['money'] += $dayExpends['money'];

        return ['lastWeek'=>$lastWeek, 'thisWeek'=>$thisWeek];
    }

    //汇总当天数据／天
    public function groupDayByDay($data)
    {   
        //初始化
        $default = [
            'pv_number'=> 0,
            'ip_number'=> 0,
            'click_number'=> 0,
            'money'=> 0,
        ];
        
  
        foreach($data as $key=>$val)
        {   
            if(substr($val['time'], 0, 10)==date('Y-m-d'))
            {
                $default['pv_number'] += $val['pv'];
                $default['ip_number'] += $val['ip'];
                $default['click_number'] += $val['click'];
                $default['money'] += $val['money'];
            }
        }

        return $default;
    }
}