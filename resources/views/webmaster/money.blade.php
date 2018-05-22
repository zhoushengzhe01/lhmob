@extends('webmaster.layout')

@section('content')
<div class="title"> 财务结算</div>

<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th class="t_c" width="20%"> &nbsp;银行名称</th>
            <th class="t_c" width="20%">银行账户</th>
            <th class="t_c" width="15%">收款人</th>
            <th class="t_c" width="15%">提现金额</th>
            <th class="t_c" width="10%">状态</th>
            <th class="t_c" width="20%">时间</th>
        </tr>
        @foreach ($money as $key=>$val)
        <tr>
            <td class="t_c">{{$val->bank_name}}</td>
            <td class="t_c">{{$val->bank_card}}</td>
            <td class="t_c">{{$val->bank_account}}</td>
            <td class="t_c">{{$val->money}} 元</td>
            <td class="t_c">@if($val->state=='1') <span style="color:red;">等待汇款</span> @elseif($val->state=='2') <span style="color:green;">汇款成功</span> @elseif($val->state=='3') 汇款失败 @endif </td>
            <td class="t_c">{{$val->created_at}}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection