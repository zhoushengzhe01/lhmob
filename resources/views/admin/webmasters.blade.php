@extends('admin.layout')

@section('content')
<div class="title"> 站长会员</div>
<div class="tool o_h">
    <a href="#" class="f_l sm_btn btn_color2">+ 添加站长</a>
    <div class="search f_r">
        <form method="get">
            <input class="text" type="text" name="qq" placeholder="QQ搜索" value="{{$paramet['qq']}}">
            <input class="text" type="text" name="username" placeholder="用户名" value="{{$paramet['username']}}">
            <input class="text" type="text" name="id" placeholder="ID" size="4" value="{{$paramet['id']}}">
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="4%"> &nbsp;ID</th>
            <th width="10%">用户名</th>
            <th width="8%">真实姓名</th>
            <th width="12%">QQ号码</th>
            <th width="8%">结算类型</th>
            <th width="10%">余额</th>
            <th width="8%">状态</th>
            <th width="15%">注册时间</th>
            <th>操作</th>
        </tr>
        @foreach ($webmasters as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->id}}</td>
            <td>{{$val->username}}</td>
            <td>{{$val->nickname}}</td>
            <td>{{$val->qq}}</td>
            <td>@if($val->withdrawals_type==1) 日结 @else 周结 @endif</td>
            <td>{{$val->money}} 元</td>
            <td>@if($val->state==1) <span style="color: green;">正常</span> @elseif($val->state==2) <span style="color: red;">被封</sapn> @endif</td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="{{$global->url}}/webmaster?id={{$val->id}}">编辑<a>&nbsp;
                <a href="{{$global->url}}/websites?webmaster_id={{$val->id}}">网站<a>&nbsp;
                <a href="{{$global->url}}/webmasterads?webmaster_id={{$val->id}}">广告位<a>&nbsp;
                <a href="{{$global->url}}/moneylogs?webmaster_id={{$val->id}}">余额变动<a>&nbsp;
                <a href="{{$global->url}}/moneys?webmaster_id={{$val->id}}">提现<a>&nbsp;
                <a href="{{$global->url}}/rewards?webmaster_id={{$val->id}}">奖励<a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $webmasters->appends($paramet)->links() !!}
</div>
@endsection