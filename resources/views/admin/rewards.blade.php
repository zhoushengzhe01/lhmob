@extends('admin.layout')

@section('content')
<div class="title"> 站长奖励</div>
<div class="tool o_h">
    <a href="/admin/reward" class="f_l sm_btn btn_color2">+ 增加奖励</a>
    <div class="search f_r">
        <form method="get" action="">
            <input class="text" type="text" name="webmaster_id" value="{{$paramet['webmaster_id']}}" placeholder="站长ID">
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="8%"> &nbsp;站长ID</th>
            <th width="20%">站长</th>
            <th width="20%">奖励金额</th>
            <th width="20%">说明</th>
            <th width="20%">时间</th>
            <th>操作</th>
        </tr>
        @foreach ($rewards as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->username}}</td>
            <td>{{$val->money}} 元</td>
            <td>{{$val->note}}</td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="/admin/reward?id={{$val->id}}">编辑</a>&nbsp;
                <a href="/admin/rewards?webmaster_id={{$val->webmaster_id}}">所有奖励</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>
    
    {!! $rewards->appends($paramet)->links() !!}
</div>
@endsection