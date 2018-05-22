<?php
namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WebmasterWebsiteCategory;
use App\Model\Webmaster;
use App\Model\Users;
use App\Model\Banks;
use Hash;
use Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //公共变量
        $group = [];

        //验证是否登录
        $webmaster_id = Session::get('webmaster_id');
        $webmaster_name = Session::get('webmaster_name');

        if(empty($webmaster_id) || empty($webmaster_name))
        {
            header("Location: /login/web");
            die;
        }

        //查找广告主
        $webmaster = Webmaster::where('id', '=', $webmaster_id)->where('username', '=', $webmaster_name)->first();
        if(empty($webmaster))
        {
            header("Location: /login/web");
            die;
        }
        
        if($webmaster->state=='2')
        {
            die('账户已关闭，请联系你的客服。');
        }

        //查找商务
        $webmaster->service = Users::where('id', '=', $webmaster->service_id)->first();

        $group['webmaster'] = $webmaster;
        $group['adsType'] = config('other.adsType');
        $group['domain'] = 'http://lhmob.cxmyq.com';
        $group['image_domain'] = 'http://image.cxmyq.com';
        $group['hours'] = config('other.hours');
        $group['page'] = 'home';
        $group['banks'] = Banks::get(['name', 'id']);

        //查找流量分类
        $group['categorys'] = WebmasterWebsiteCategory::where('state', '=', '1')->get(['id','name'])->toArray();

        return view('webmaster', ['group'=>$group]);
    }

    public function index1(Request $request)
    {
        //验证登陆
        self::Webmaster();

        //银行
        self::$webmaster->bank = WebmasterBank::getBank(['webmaster_id'=>self::$webmaster->id]);
        
        //昨天收益
        $yesterday_money = EarningDay::where('webmaster_id', '=', self::$webmaster->id)
            ->where('time', '>=', date("Y-m-d",strtotime("-1 day")).' 00:00:00')
            ->where('time', '<', date("Y-m-d").' 00:00:00')
            ->sum('money');

        //本周收益
        $thisweek_money = EarningDay::where('webmaster_id', '=', self::$webmaster->id)
            ->where('time', '>=', date('Y-m-d', strtotime('-1 monday', time())).' 00:00:00')
            ->sum('money');

        //上周收益
        $lastweek_money = EarningDay::where('webmaster_id', '=', self::$webmaster->id)
            ->where('time', '>=', date('Y-m-d', strtotime('-2 monday', time())).' 00:00:00')
            ->where('time', '<', date('Y-m-d', strtotime('-1 monday', time())).' 00:00:00')
            ->sum('money');
        

        //查找广告类型
        $adsPosition = AdsPosition::get();

        $data = ['周一', '周二', '周三', '周四', '周五', '周六', '周日', '周一', '周二', '周三', '周四', '周五', '周六', '周日'];
        $time = strtotime(date('Y-m-d', strtotime('-2 monday', time())));

        $earning = [];
        foreach($adsPosition as $key=>$val)
        {
            $EarningDay = EarningDay::where('webmaster_id', '=', self::$webmaster->id)
                ->where('position_id', '=', $val->id)
                ->where('time', '>=', date('Y-m-d H:i:s', $time))
                ->get();

            foreach($data as $k=>$v)
            {
                if($key==0)
                {
                    $data[$k] = date('y-m-d',strtotime('+'.$k.' day', $time)).'<br>'.$v;
                }

                $this_time = date('Y-m-d H:i:s',strtotime('+'.$k.' day', $time));
                $money = 0;
                
                if( strtotime($this_time) < strtotime(date('Y-m-d')) )
                {
                    foreach($EarningDay as $j=>$n)
                    {
                        if($this_time==$n->time)
                        {
                            $money = $n->money;
                            continue;
                        }
                    }
                }

                if( strtotime($this_time) == strtotime(date('Y-m-d')) )
                {
                    //今天的
                    $h_money = EarningHour::where('webmaster_id', '=', self::$webmaster->id)
                        ->where('position_id', '=', $val->id)
                        ->where('statec', '=', '1')
                        ->where('time', '>=', date('Y-m-d').' 00:00:00')
                        ->sum('money');
                
                    $m_money = EarningMinute::where('webmaster_id', '=', self::$webmaster->id)
                        ->where('position_id', '=', $val->id)
                        ->where('statec', '=', '1')
                        ->where('time', '>=', date('Y-m-d').' 00:00:00')
                        ->sum('money');
                    
                    $money = $h_money + $m_money;
                }

                $earning[$val->id][] = round($money, 2);

            }

            $earning[$val->id]['data'] = implode(',', $earning[$val->id]);
            $earning[$val->id]['name'] = $val->name;
        }


        //收益报表
        $earningHour = EarningHour::where('earning_hour.webmaster_id', '=', self::$webmaster->id)
            ->where('earning_hour.time', '>=', date('Y-m-d').' 00:00:00')
            ->leftJoin('ads_position', 'earning_hour.position_id', '=', 'ads_position.id')
            ->select('earning_hour.*', 'ads_position.name as ads_name')->paginate(24);

        $data = [
            'title'=>'管理首页',
            'website'=>self::$website,
            'webmaster'=>self::$webmaster,
            'yesterday_money'=>round($yesterday_money, 2),
            'thisweek_money'=>round($thisweek_money, 2),
            'lastweek_money'=>round($lastweek_money, 2),
            'earning'=>$earning,
            'earningHour'=>$earningHour,
            'data'=>implode("','", $data),
        ];

        return view('webmaster.index', $data);
    }
}
