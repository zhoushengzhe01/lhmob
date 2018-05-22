@extends('admin.layout')

@section('content')
<div class="title"> 每天收益</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="8%"> &nbsp;站长ID</th>
            <th width="8%">广告ID</th>
            <th width="10%">PV数量</th>
            <th width="10%">PC数量</th>
            <th width="10%">收益</th>
            <th width="15%">时间</th>
            <th width="15%">点击率</th>
            <th></th>
        </tr>
        @foreach ($earnings as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->myads_id}}</td>
            <td>{{$val->pv}}</td>
            <td>{{$val->click}}</td>
            <td>{{$val->money}} 元</td>
            <td>{{$val->time}}</td>
            <td class="t_l">
                <div class="proportion">
                    <span style="width: {{@round($val->click/$val->pv, 4) * 200}}%;"></span>
                    {{@round($val->click/$val->pv, 4) * 100}}%
                </div>
            </td>
            <td></td>
        </tr>
        @endforeach
    </table>

    {!! $earnings->appends($paramet)->links() !!}
</div>
@endsection