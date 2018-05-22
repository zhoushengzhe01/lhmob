<?php
namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WebmasterWebsiteCategory;
use App\Model\Advertiser;
use App\Model\Users;
use Hash;
use Session;

class HomeController extends Controller
{
    //访问入口函数
    public function index(Request $request)
    {
        //公共变量
        $group = [];

        //验证是否登录
        $advertiser_id = Session::get('advertiser_id');
        $advertiser_name = Session::get('advertiser_name');

        if(empty($advertiser_id) || empty($advertiser_name))
        {
            header("Location: /login/ad");
            die;
        }

        //查找广告主
        $advertiser = Advertiser::where('id', '=', $advertiser_id)->where('username', '=', $advertiser_name)->first();
        if(empty($advertiser))
        {
            header("Location: /login/ad");
            die;
        }

        if($advertiser->state=='2')
        {
            die('账户已关闭，请联系你的对接商务。');
        }

        //查找商务
        $advertiser->busine = Users::where('id', '=', $advertiser->busine_id)->first();

        $group['advertiser'] = $advertiser;
        $group['adsType'] = config('other.adsType');
        $group['domain'] = 'http://lhmob.cxmyq.com';
        $group['image_domain'] = 'http://image.cxmyq.com';
        $group['hours'] = config('other.hours');
        $group['page'] = 'home';

        //查找流量分类
        $group['categorys'] = WebmasterWebsiteCategory::where('state', '=', '1')->get(['id','name'])->toArray();

        return view('advertiser', ['group'=>$group]);
    }
}
