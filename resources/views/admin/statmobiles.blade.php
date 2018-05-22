@extends('admin.layout')

@section('content')
<div class="title"> 浏览器统计</div>
<div class="tool o_h">
    <form method="get" action="">
        <select name="orderby">
            <option value="pv" @if ($paramet['orderby']=='pv') selected @endif >PV排序</option>
            <option value="ip" @if ($paramet['orderby']=='ip') selected @endif >IP排序</option>
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
            <th width="15%">手机品牌</th>
            <th width="6%" class="t_r">曝光PV</th>
            <th width="6%" class="t_r">曝光IP</th>
            <th width="8%" class="t_r">PV/IP &nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th width="10%">计费率</th>
            <th width="10%">IP贡献率</th>
            <th width="10%">PV贡献率</th>
            <th width="10%">IP占有率</th>
            <th width="10%">PV占有率</th>
            <th></th>
        </tr>
        @foreach ($mobiles as $key=>$val)
        
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->myads_id}}</td>
            <td>{{$val->mobile}}</td>
            <td class="t_r">{{number_format($val->pv)}}</td>
            <td class="t_r">{{number_format($val->ip)}}</td>
            <td class="t_r">{{@round($val->pv/$val->ip, 1)}} &nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->clickpv/$val->pv, 3) * 200}}%;"></span>
                    {{@round($val->clickpv/$val->pv, 3) * 100}}%
                </div>
            </td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->clickip/$val->ip, 3) * 200}}%;"></span>
                    {{@round($val->clickip/$val->ip, 3) * 100}}%
                </div>
            </td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->clickpv/$val->pv, 3) * 200}}%;"></span>
                    {{@round($val->clickpv/$val->pv, 3) * 100}}%
                </div>
            </td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->ip/$countip, 3) * 200}}%;"></span>
                    {{@round($val->ip/$countip, 3) * 100}}%
                </div>
            </td>
            <td>
                <div class="proportion">
                    <span style="width: {{@round($val->pv/$countpv, 3) * 200}}%;"></span>
                    {{@round($val->pv/$countpv, 3) * 100}}%
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    
    {!! $mobiles->appends($paramet)->links() !!}
</div>
@endsection