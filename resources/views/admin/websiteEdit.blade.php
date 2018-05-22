@extends('admin.layout')

@section('content')
<div class="title"> 网站编辑</div>
<div class="content">
<form action="" method="post">
    <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
    <tbody>
        <tr class="top">
            <td class="t_r" width="20%">网站名称：</td>
            <td class="t_l" width="80%"><input type="text" class="text" name="name" value="{{$website->name}}" size="40" maxlength="100"></td>
        </tr>
        <tr>
            <td class="t_r">网站域名：</td>
            <td class="t_l"><input type="text" class="text" name="domain" value="{{$website->domain}}" size="40" maxlength="100"> </td>
        </tr>
        <tr>
            <td class="t_r">备案号：</td>
            <td class="t_l"><input type="text" class="text" name="icp" value="{{$website->icp}}" size="40" maxlength="100"> </td>
        </tr>
        <tr>
            <td class="t_r">分类：</td>
            <td class="t_l">
            <select name="category_id">
                @foreach ($categorys as $key=>$val)
                <option value="{{$val->id}}" @if($website->category_id==$val->id) selected @endif>{{$val->name}}</option>
                @endforeach
            </select>
            </td>
        </tr>
        <tr>
            <td class="t_r">状态：</td>
            <td class="t_l">
            <select name="state">
                <option value="0" @if($website->state=='0') selected @endif>等待审核</option>
                <option value="1" @if($website->state=='1') selected @endif>审核通过</option>
                <option value="2" @if($website->state=='2') selected @endif>审核拒绝</option>
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