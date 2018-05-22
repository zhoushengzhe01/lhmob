@extends('admin.layout')

@section('content')
<div class="title"> 编辑联盟</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            @if ($itemuser)
            <tr class="top">
                <td class="t_r">所属部门：</td>
                <td class="t_l">
                <select name="department_id">
                    @foreach ($department as $key=>$val)
                    <option value="{{$val->id}}" @if ($itemuser->department_id==$val->id) selected @endif >{{$val->name}}</option>
                    @endforeach
                </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">用户名：</td>
                <td class="t_l"><input type="text" class="text" name="username" value="{{$itemuser->username}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">真实姓名：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="{{$itemuser->nickname}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">艺名：</td>
                <td class="t_l"><input type="text" class="text" name="stagename" value="{{$itemuser->stagename}}" size="40" maxlength="100"> <span class="tishi">客服和商务才会有</span></td>
            </tr>
            <tr>
                <td class="t_r">登录密码：</td>
                <td class="t_l"><input type="text" class="text" name="password" value="" size="40" maxlength="100"> <span class="tishi">为空则不修改</span></td>
            </tr>
            <tr>
                <td class="t_r">电话号码：</td>
                <td class="t_l"><input type="text" class="text" name="mobile" value="{{$itemuser->mobile}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">电子邮箱：</td>
                <td class="t_l"><input type="text" class="text" name="email" value="{{$itemuser->email}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">QQ 号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="{{$itemuser->qq}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                <select name="state">
                    <option value="1" @if($itemuser->state=='1') selected @endif>正常</option>
                    <option value="2" @if($itemuser->state=='2') selected @endif>关闭</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @else
            <tr class="top">
                <td class="t_r">所属部门：</td>
                <td class="t_l">
                <select name="department_id">
                    @foreach ($department as $key=>$val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">用户名：</td>
                <td class="t_l"><input type="text" class="text" name="username" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">真实姓名：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">艺名：</td>
                <td class="t_l"><input type="text" class="text" name="stagename" value="" size="40" maxlength="100"> <span class="tishi">客服和商务才会有</span></td>
            </tr>
            <tr>
                <td class="t_r">登录密码：</td>
                <td class="t_l"><input type="text" class="text" name="password" value="" size="40" maxlength="100"> </td>
            </tr>
            <tr>
                <td class="t_r">电话号码：</td>
                <td class="t_l"><input type="text" class="text" name="mobile" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">电子邮箱：</td>
                <td class="t_l"><input type="text" class="text" name="email" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">QQ 号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                <select name="state">
                    <option value="1">正常</option>
                    <option value="2">关闭</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @endif
        </tbody>
        </table>
    </form>
</div>
@endsection