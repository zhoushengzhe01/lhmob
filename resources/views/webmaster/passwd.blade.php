@extends('webmaster.layout')

@section('content')
<div class="title"> 修改密码</div>
<div class="content">
    <!--添加-->
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">登录账号：</td>
                <td class="t_l" width="80%">{{$webmaster->username}}</td>
            </tr>
            <tr>
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