<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\WebmasterWebsiteCategory;
use App\Model\Alliance;
use App\Model\Users;
use App\Model\UsersDepartment;

use Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //公共变量
        $group = [];

        //验证是否登录
        $user_id = Session::get('user_id');
        $user_name = Session::get('user_name');
        
        if(empty($user_id) || empty($user_name))
        {
            header("Location: /admin/login"); 
            die;
        }

        //用户
        $user = Users::where('id', '=', $user_id)->where('username', '=', $user_name)->first();
        if(empty($user))
        {
            header("Location: /admin/login"); 
            die;
        }
        
        if($user->state=='2')
        {
            die('账号已经关闭');
        }
        
        $group['user'] = $user;
        $group['adsType'] = config('other.adsType');
        $group['domain'] = 'http://lhmob.cxmyq.com';
        $group['image_domain'] = 'http://image.cxmyq.com';
        $group['hours'] = config('other.hours');
        $group['page'] = 'home';

        //查找网站分类
        $group['categorys'] = WebmasterWebsiteCategory::where('state', '=', '1')->get(['id','name'])->toArray();

        $group['alliances'] = Alliance::where('state', '=', '1')->get(['id','name'])->toArray();

        $group['departments'] = UsersDepartment::where('state', '=', '1')->get(['id','name'])->toArray();

        return view('admin', ['group'=>$group]);
    }
}
