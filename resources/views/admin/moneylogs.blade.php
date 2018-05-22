@extends('admin.layout')

@section('content')
<div class="title"> 余额变动</div>
<div class="tool o_h">
    <span class="f_l sm_btn btn_color2">{{$all_money}} 元</span>
    <div class="search f_r" style="width: 260px;">
        <form method="get" action="">
            <input class="text" type="text" name="webmaster_id" value="{{$paramet['webmaster_id']}}" placeholder="站长ID">
            <input class="sm_btn btn_color" type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="8%"> &nbsp;站长ID</th>
            <th width="12%">站长名称</th>
            <th width="50%">说明</th>
            <th width="8%">状态</th>
            <th width="8%">金额</th>
            <th>时间</th>
        </tr>
        @foreach ($moneylogs as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->username}}</td>
            
            <td>{{$val->message}}</td>
            <td>@if($val->state=='1') <span style="color:green">使用</span> @elseif ($val->state=='2') <span style="color:#ccc">禁止</span> @endif</td>
            <td>{{$val->money}} 元</td>
            <td>{{$val->created_at}}</td>
        </tr>
        @endforeach
    </table>

    {!! $moneylogs->appends($paramet)->links() !!}
</div>
@endsection