@extends('advertiser.layout')

@section('content')
<div class="title"> 我的素材</div>
<div class="tool o_h">
    <a href="/advertiser/package" class="sm_btn btn_color2">添加素材</a>
    <div class="search f_r">
        <form method="get" action="">
            <select name="adstype_id">
                <option value="">所有类型</option>
                @foreach ($adsPosition as $key=>$val)
                <option value="{{$val['id']}}" @if($paramet['adstype_id']==$val['id']) selected @endif)>{{$val['name']}}</option>
                @endforeach
            </select>
            <input class="text" type="text" size="10" name="name" value="{{$paramet['name']}}" placeholder="素材名称...">
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th class="t_c"> &nbsp;id号</th>
            <th class="t_c">素材名称</th>
            <th class="t_c">广告类型</th>
            <th class="t_c">素材一</th>
            <th class="t_c">素材二</th>
            <th class="t_c">素材三</th>
            <th class="t_c">状态</th>
            <th class="t_c">时间</th>
            <th class="t_c">操作</th>
        </tr>
        @foreach ($matterPackages as $key=>$val)
        <tr>
            <td class="t_c">{{$val->id}}</td>
            <td class="t_c">{{$val->name}}</td>
            <td class="t_c">{{$val->adstype_id}}</td>
            <td class="t_c">{{$val->picture1}}</td>
            <td class="t_c">{{$val->picture2}}</td>
            <td class="t_c">{{$val->picture3}}</td>
            <td class="t_c">@if($val->state=='1') <span style="color:green;">正常</span> @elseif($val->state=='2') <span style="color:red;">空闲</span> @endif</td>
            <td class="t_c">{{$val->created_at}}</td>
            <td class="t_c">
                <a href="#">编辑</a>&nbsp;
                <a href="#">查看</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection