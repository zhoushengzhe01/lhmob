@extends('webmaster.layout')

@section('content')
<div class="title"> 奖励报表</div>

<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th class="t_c" width="50%"> &nbsp; 时间</th>
            <th class="t_c" width="50%">金额</th>
        </tr>
        @foreach ($reward as $key=>$val)
        <tr>
            <td class="t_c">{{$val->created_at}}</td>
            <td class="t_c">{{$val->money}} 元</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection