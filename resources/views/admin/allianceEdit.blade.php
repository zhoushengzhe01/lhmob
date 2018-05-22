@extends('admin.layout')

@section('content')
<div class="title"> 编辑联盟</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">联盟名字：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="name" value="{{$alliance->name}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">联盟地址：</td>
                <td class="t_l"><input type="text" class="text" name="login_url" value="{{$alliance->login_url}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">联盟账号：</td>
                <td class="t_l"><input type="text" class="text" name="account" value="{{$alliance->account}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">联盟密码：</td>
                <td class="t_l"><input type="text" class="text" name="password" value="{{$alliance->password}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">记录次数：</td>
                <td class="t_l"><input type="text" class="text" name="record_num" value="{{$alliance->record_num}}" size="10" maxlength="100"> <span class="tishi">次</span></td>
            </tr>
            <tr>
                <td class="t_r">计费价格：</td>
                <td class="t_l"><input type="text" class="text" name="price" value="{{$alliance->price}}" size="10" maxlength="100"> <span class="tishi">元／1000次</span></td>
            </tr>
            <tr>
                <td class="t_r">广告类型：</td>
                <td class="t_l">
                    @foreach ($adsPosition as $key=>$val)
                    <label onclick="click_adstype('{{$val->id}}')"><input type="radio" name="position_id" @if($alliance->position_id==$val->id) checked @endif value="{{$val->id}}">{{$val->name}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="t_r">广告位置：</td>
                <td class="t_l">
                    <label><input type="radio" name="position" @if($alliance->position=='1') checked @endif value="1">顶浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="position" @if($alliance->position=='2') checked @endif value="2">底浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="position" @if($alliance->position=='3') checked @endif value="3">顶浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="position" @if($alliance->position=='4') checked @endif value="4">底浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td class="t_r">广告代码：</td>
                <td class="t_l">
                <textarea rows="8" cols="80" name="code">{{$alliance->code}}</textarea>
                </td>
            </tr>
            <tr>
                <td class="t_r">统计代码：</td>
                <td class="t_l">
                <textarea rows="8" cols="80" name="stat_code">{{$alliance->stat_code}}</textarea>
                </td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                <select name="state">
                    <option value="1" @if($alliance->state=='1') selected @endif>使用</option>
                    <option value="2" @if($alliance->state=='2') selected @endif>停止</option>
                </select>
                </td>
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