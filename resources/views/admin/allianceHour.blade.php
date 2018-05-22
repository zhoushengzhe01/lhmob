@extends('admin.layout')

@section('content')
<div class="title"> 联盟支出</div>
<div class="tool o_h">
    <span class="f_l sm_btn btn_color2">金额：{{$all_expend}} 元</span>
    <span class="f_l sm_btn btn_color2">展示：{{$all_pv}}</span>
    <div class="search f_r">
        <form method="get" action="">
            <input class="text" type="text" name="time" id="time" size=12 value="{{$paramet['time']}}" placeholder="时间搜索">
            <select name="alliance_id">
                <option value="0">所有联盟</option>
                @foreach ($alliance as $key=>$val)
                <option value="{{$val->id}}" @if ($val->id==$paramet['alliance_id']) selected @endif >{{$val->name}}</option>
                @endforeach
            </select>
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<script>
laydate.render({
    elem: '#time'
});
</script>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="180"> &nbsp;名称</th>
            <th width="120">计费次数</th>
            <th width="120">价格</th>
            <th width="120">点击次数</th>
            <th width="140">PV次数</th>
            <th width="120">点击率</th>
            <th width="120">支出</th>
            <th>时间</th>
        </tr>
        @foreach ($allianceHour as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->alliance_name}}</td>
            <td>{{$val->alliance_record_num}} 次</td>
            <td>{{$val->alliance_price}} 元</td>
            <td>点：{{$val->click_number}}</td>
            <td>展：{{$val->pv_number}}</td>
            <td>{{$val->click_rate}}%</td>
            <td>{{$val->expend}} 元</td>
            <td>{{$val->time}}</td>
        </tr>
        @endforeach
    </table>

    {!! $allianceHour->appends($paramet)->links() !!}
</div>
@endsection