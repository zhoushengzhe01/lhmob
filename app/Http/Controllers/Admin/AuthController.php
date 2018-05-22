<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
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
        
        $user = Users::where('username', '=', $present['username'])->first();

        if(empty($user))
            return response()->json(['message'=>'用户名不存在'], 300);
       
        if (!Hash::check($present['password'], $user->password))
        {
            return response()->json(['message'=>'用户名或密码错误'], 300);
        }

        //储层session
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->username);
        
        return response()->json(['message'=>'登陆成功', 'url'=>'/admin'], 200);
    }

    //推出
    public function putLogout(Request $request)
    {
        Session::put('user_id', '');
        Session::put('user_name', '');
        
        return response()->json(['message'=>'推出成功', 'url'=>'/admin/login'], 200);
    }
}