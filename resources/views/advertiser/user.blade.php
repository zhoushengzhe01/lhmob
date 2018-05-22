@extends('advertiser.layout')

@section('content')
<div class="title"> 基本资料</div>
<div class="content">
    <!--添加-->
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">登录邮箱：</td>
                <td class="t_l" width="80%">{{$group['advertiser']->username}}</td>
            </tr>
            <tr>
                <td class="t_r">公司名称：</td>
                <td class="t_l"><input type="text" class="text" name="company" value="{{$group['advertiser']->company}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">联 &nbsp;系 人：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="{{$group['advertiser']->nickname}}" size="40" maxlength="100"></td>
            </tr>
            
            <tr>
                <td class="t_r">联系手机：</td>
                <td class="t_l"><input type="text" class="text" name="mobile" value="{{$group['advertiser']->mobile}}" size="40" maxlength="100"></td>
            </tr>
            
            <tr>
                <td class="t_r">QQ号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="{{$group['advertiser']->qq}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>

<div class="title"> 修改密码</div>
<div class="content">
    <!--添加-->
    <form action="/advertiser/passwd" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r">旧密码：</td>
                <td class="t_l"><input type="password" class="text" name="oldpasswd" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">新密码：</td>
                <td class="t_l"><input type="password" class="text" name="newpasswd" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">确认密码：</td>
                <td class="t_l"><input type="password" class="text" name="newpasswd1" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>
@endsection