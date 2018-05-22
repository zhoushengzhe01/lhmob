@extends('admin.layout')

@section('content')
<div class="title"> 浏览器统计</div>
<div class="tool o_h">
    <form method="get" action="">
        <select name="orderby">
            <option value="clickpv" @if ($paramet['orderby']=='clickpv') selected @endif >PV排序</option>
            <option value="clickip" @if ($paramet['orderby']=='clickip') selected @endif >IP排序</option>
        </select>
        <input class="text" type="text" name="webmaster_id" size="8" value="{{$paramet['webmaster_id']}}" placeholder="站长ID">
        <input class="text" type="text" name="myads_id" size="8" value="{{$paramet['myads_id']}}" placeholder="广告ID">
        <input class="text" type="text" name="date" value="{{$paramet['date']}}" placeholder="时间：2018-02-02">
        
        <input type="submit" value="查 询">
    </form>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="60"> &nbsp;站长ID</th>
            <th width="60">广告ID</th>
            <th width="15%">点击位置</th>
            <th width="8%">点击IP</th>
            <th width="8%">点击PV</th>
            <th width="8%">PV/PV</th>
            <th width="15%">IP占用率</th>
            <th width="15%">PV占用率</th>
            <th></th>
        </tr>
        @foreach ($locations as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->myads_id}}</td>
            <td>{{$val->location}}</td>
            <td>{{$val->clickip}}</td>
            <td>{{$val->clickpv}}</td>
            <td>{{ @round($val->clickpv/$val->clickip, 1)}}</td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->clickip/$countip, 3) * 200}}%;"></span>
                    {{@round($val->clickip/$countip, 3) * 100}}%
                </div>
            </td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->clickpv/$countpv, 3) * 200}}%;"></span>
                    {{@round($val->clickpv/$countpv, 3) * 100}}%
                </div>
            </td>
            <td></td>
        </tr>
        @endforeach
    </table>
    
    {!! $locations->appends($paramet)->links() !!}
</div>
@endsection