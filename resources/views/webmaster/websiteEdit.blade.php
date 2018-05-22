@extends('webmaster.layout')

@section('content')
<div class="title"> 添加／编辑网站</div>

<div class="prompt">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
    禁止淫秽、色情、赌博、暴力或者教唆犯罪等违反国家法律、法规的网站投放本联盟代码，一经发现，将立即做封号处理。
</div>

<div class="content">
<!--添加-->
@if ($action=='add')
<form action="" method="post">
    <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
    <tbody>
        <tr class="top">
            <td class="t_r" width="20%">网站名称：</td>
            <td class="t_l" width="80%"><input type="text" class="text" name="name" size="40" maxlength="100"></td>
        </tr>
        <tr>
            <td class="t_r">网站域名：</td>
            <td class="t_l"><input type="text" class="text" name="domain" size="40" maxlength="100"> <span class="tishi">如：baidu.com</span></td>
        </tr>
        <tr>
            <td class="t_r">备案号：</td>
            <td class="t_l"><input type="text" class="text" name="icp" size="40" maxlength="100"> </td>
        </tr>
        <tr>
            <td class="t_r">网站分类：</td>
            <td class="t_l">
                <select name="category_id">
                    @foreach ($category as $key=>$val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>{!! csrf_field() !!}</td>
            <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
        </tr>
    </tbody>
    </table>
</form>
@endif
<!--修改-->
@if ($action=='edit')
<form action="" method="post">
    <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
    <tbody>
        <tr class="top">
            <td class="t_r" width="20%">网站名称：</td>
            <td class="t_l" width="80%"><input type="text" class="text" name="name" value="{{$mywebsite->name}}" size="40" maxlength="100"></td>
        </tr>
        <tr>
            <td class="t_r">网站域名：</td>
            <td class="t_l"><input type="text" class="text" name="domain" value="{{$mywebsite->domain}}" size="40" maxlength="100"> <span class="tishi">如：baidu.com</span></td>
        </tr>
        <tr>
            <td class="t_r">备案号：</td>
            <td class="t_l"><input type="text" class="text" name="icp" value="{{$mywebsite->icp}}" size="40" maxlength="100"> </td>
        </tr>
        <tr>
            <td class="t_r">网站分类：</td>
            <td class="t_l">
            <select name="category_id">
                @foreach ($category as $key=>$val)
                <option value="{{$val->id}}" @if($mywebsite->category_id==$val->id) selected @endif>{{$val->name}}</option>
                @endforeach
            </select>
            </td>
        </tr>
        <tr>
            <td>{!! csrf_field() !!}</td>
            <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
        </tr>
    </tbody>
    </table>
</form>
@endif
</div>
@endsection