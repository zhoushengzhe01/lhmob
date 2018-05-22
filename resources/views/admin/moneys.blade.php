@extends('admin.layout')

@section('content')
<div class="title"> 站长提现</div>
<div class="tool o_h">
    <span class="f_l sm_btn btn_color2">金额：{{$all_money}} 元</span>
    <div class="search f_r">
        <form method="get" action="">
        <input class="text" type="text" size="10" name="webmaster_id" value="{{$paramet['webmaster_id']}}" placeholder="站长ID">
            <input class="text" type="text" id="time" size="22" name="time" value="{{$paramet['time']}}" placeholder="日期范围">
            <select name="state">
                <option value="">所有收益</option>
                <option value="1" @if ($paramet['state']=='1') selected @endif>未结算</option>
                <option value="2" @if ($paramet['state']=='2') selected @endif>已结算</option>
                <option value="3" @if ($paramet['state']=='3') selected @endif>驳回</option>
            </select>
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<script>
laydate.render({
    elem: '#time'
    ,range: true
});
</script>

<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="120"> &nbsp;站长</th>
            <th width="80">结算类型</th>
            <th width="100">银行名称</th>
            <th width="100">收款人</th>
            <th width="280">银行账号/支行</th>
            <th width="100">金额</th>
            <th width="100">状态</th>
            <th width="160">时间</th>
            <th>操作</th>
        </tr>
        @foreach ($moneys as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->username}}</td>
            <td>@if ($val->type=='1') 日结 @else 周结 @endif</td>
            <td>{{$val->bank_name}}</td>
            <td>{{$val->bank_account}}</td>
            <td>
                {{substr($val->bank_card, 0 ,4)}}
                {{substr($val->bank_card, 4 ,4)}}
                {{substr($val->bank_card, 8 ,4)}}
                {{substr($val->bank_card, 12 ,4)}}
                {{substr($val->bank_card, 16 ,4)}}
                {{substr($val->bank_card, 20 ,4)}}
                <br/> 
                {{$val->bank_branch}}</td>
            <td>{{$val->money}} 元</td>
            <td>@if ($val->state=='1') <span style="color:red">未结算</span> @elseif ($val->state=='2') <span style="color:#00ba8b">已结算</span> @elseif ($val->state=='3') <span style="color:#ccc">驳回</span> @endif </td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="/admin/money?id={{$val->id}}">编辑</a>&nbsp;
                <a href="/admin/moneys?webmaster_id={{$val->webmaster_id}}">所有提现</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $moneys->appends($paramet)->links() !!}
</div>
@endsection