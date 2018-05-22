@extends('webmaster.layout')

@section('content')
<div class="title"> 基本资料</div>
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
                <td class="t_r">真实姓名：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="{{$webmaster->nickname}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">联系手机：</td>
                <td class="t_l"><input type="text" class="text" name="mobile" value="{{$webmaster->mobile}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">电子邮箱：</td>
                <td class="t_l"><input type="text" class="text" name="email" value="{{$webmaster->email}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">QQ号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="{{$webmaster->qq}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>

<div class="title"> 收款账户</div>
<div class="content">
    <!--添加-->
    <form action="/webmaster/bank" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            @if($mybank)
            <tr class="top">
                <td class="t_r" width="20%">收款银行：</td>
                <td class="t_l" width="80%">
                    <select name="bankname" style="width:240px">
                        @foreach ($banks as $key=>$val)
                        <option value="{{$val->name}}" @if($mybank->bankname==$val->name) selected @endif>{{$val->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r" width="20%">开户行：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="branch" value="{{$mybank->branch}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r" width="20%">银行账号：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="accountid" value="{{$mybank->accountid}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r" width="20%">开户姓名：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="account" value="{{$mybank->account}}" size="40" maxlength="100"></td>
            </tr>
            @else
            <tr class="top">
                <td class="t_r" width="20%">收款银行：</td>
                <td class="t_l" width="80%">
                    <select name="bankname" style="width:240px">
                        @foreach ($banks as $key=>$val)
                        <option value="{{$val->name}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r" width="20%">开户行：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="branch" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r" width="20%">银行账号：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="accountid" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r" width="20%">开户姓名：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="account" value="" size="40" maxlength="100"></td>
            </tr>
            @endif

            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>
@endsection