@extends('admin.layout')

@section('content')
<div class="title"> 广告收益</div>
<div class="tool o_h">
    <a href="/admin/webmasterads?position_name=11" class="f_l sm_btn btn_color2">横幅</a>
    <a href="/admin/webmasterads?position_name=12" class="f_l sm_btn btn_color2">信息流</a>
    <a href="/admin/webmasterads?position_name=13" class="f_l sm_btn btn_color2">图标</a>
    <div class="search f_r">
        <form method="get" action="">
            <input class="text" type="text" name="webmaster_id" placeholder="站长ID">
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="6%"> &nbsp;站长ID</th>
            <th width="12%">站长名字</th>
            <th width="6%">广告类型</th>
            <th width="6%">计费方式</th>
            <th width="6%">计费率</th>
            <th width="12%">{{$time['day_three']}}</th>
            <th width="12%">{{$time['day_two']}}</th>
            <th width="12%">今天收益</th>
            <th width="6%">状态</th>
            <th class="t_l">操作</th>
        </tr>
        @foreach ($webmasterAds as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster->id}}</td>
            <td><a href="/admin/webmaster?id={{$val->webmaster->id}}">{{$val->webmaster->username}}</a></td>
            <td>{{$val->position_name}}</td>
            <td>{{$val->billing}}</td>
            <td>{{$val->price}}%</td>
            <td>
                @if($val->day_three) 
                    展:{{$val->day_three->pv}} 点:{{$val->day_three->click}}<br/>{{$val->day_three->money}}元
                @else 
                    <span style="color:#ccc">无数据</div>
                @endif
            </td>
            <td>
                @if($val->day_two)
                    展:{{$val->day_two->pv}} 点:{{$val->day_two->click}}<br/>{{$val->day_two->money}}元
                @else 
                    <span style="color:#ccc">无数据</div>
                @endif
            </td>
            <td>
                @if($val->day_one->pv || $val->day_one->click)
                    展:{{$val->day_one->pv}} 点:{{$val->day_one->click}}<br/>{{$val->day_one->money}}元
                @else 
                    <span style="color:#ccc">无数据</div>
                @endif
            </td>
            <td>@if ($val->state==1) <span style="color:green;">使用</span> @elseif ($val->state==2) <span style="color:red;">停止</span> @endif</td>
            <td class="t_l">
                <a href="/admin/webmasterad?id={{$val->id}}">编辑</a>&nbsp;
                <a href="/admin/earnings?type=day&ads_id={{$val->id}}">每天</a>&nbsp;
                <a href="/admin/earnings?type=hour&ads_id={{$val->id}}">小时</a>&nbsp;
                <a href="/admin/earnings?type=minute&ads_id={{$val->id}}">分钟</a>&nbsp;
                <a href="/admin/clicks?ads_id={{$val->id}}">点击</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $webmasterAds->links() !!}
</div>
@endsection