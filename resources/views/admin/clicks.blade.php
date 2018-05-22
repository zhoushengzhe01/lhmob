@extends('admin.layout')

@section('content')
<div class="title"> 每天收益</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="6%"> &nbsp;站长ID</th>
            <th width="10%">系统/IP</th>
            <th>来源</th>
            <th>地址</th>
            <th width="10%">间隔/其他</th>
            <th width="10%">屏幕/点击位置</th>
            <th width="10%">时间</th>
        </tr>
        @foreach ($clicks as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->system}} <br/> {{$val->ip}}</td>
            <td>{{$val->source}}</td>
            <td>{{$val->url}}</td>
            <td>{{$val->time}}秒 <br/> {{$val->refso}}</td>
            <td>屏幕：{{$val->screen}} <br/> 位置：{{$val->clickp}}</td>
            <td>{{$val->created_at}}</td>
        </tr>
        <tr>
            <td colspan="10" style="color:#ccc">{{$val->user_agent}}</td>
        </tr>
        @endforeach
    </table>

    {!! $clicks->appends($paramet)->links() !!}
</div>
@endsection