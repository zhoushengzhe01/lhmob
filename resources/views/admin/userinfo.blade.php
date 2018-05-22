@extends('admin.layout')

@section('content')
<div class="title"> 个人信息</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r">用户名：</td>
                <td class="t_l">{{$user->username}}</td>
            </tr>
            <tr>
                <td class="t_r">真实姓名：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="{{$user->nickname}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">艺名：</td>
                <td class="t_l"><input type="text" class="text" name="stagename" value="{{$user->stagename}}" size="40" maxlength="100"> <span class="tishi">客服和商务才会有</span></td>
            </tr>
            <tr>
                <td class="t_r">电话号码：</td>
                <td class="t_l"><input type="text" class="text" name="mobile" value="{{$user->mobile}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">电子邮箱：</td>
                <td class="t_l"><input type="text" class="text" name="email" value="{{$user->email}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">QQ 号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="{{$user->qq}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>
@endsection