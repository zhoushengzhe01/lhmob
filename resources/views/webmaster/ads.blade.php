@extends('webmaster.layout')

@section('content')
<div class="title"> 推荐广告位</div>

<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th> &nbsp; 广告类型</th>
            <th>计费类型</th>
            <th>计费单位</th>
            <th width="150" class="t_c">操作</th>
        </tr>
        @foreach ($adsposition as $key=>$val)
        <tr>
            <td> &nbsp; {{$val->name}}</td>
            <td>{{$val->type}}</td>
            <td>{{$val->units}}/次</td>
            <td class="t_c">
                @if ($val->state=='1')
                <a href="/webmaster/myads/add" >创建广告位</a>
                @else
                <a href="javascript:void(0)" style="color:#ccc">创建广告位</a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection