@extends('webmaster.layout')

@section('content')
<div class="title"> 我的广告位</div>
<div class="tool o_h">
    <a href="/webmaster/myads/add" class="f_l sm_btn btn_color1">+ 添加广告位</a>
    <div class="search f_r">
        <form method="get" >
            <input class="text" type="text" name="keyword" value="" placeholder="广告名称搜索">
            <input class="sm_btn btn_color" type="submit" value="查 询">
        </form>
    </div>
</div>

<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th> &nbsp; 广告ID</th>
            <th>广告名称</th>
            <th>广告类型</th>
            <th>计费类型</th>
            <th width="120" class="t_l">操作</th>
        </tr>
        @foreach ($myads as $key=>$val)
        <tr>
            <td> &nbsp; {{$val->id}}</td>
            <td>{{$val->name}}</td>
            <td>{{$val->position_name}}</td>
            <td>{{$val->billing}}</td>
            <td class="t_l">
                <a href="/webmaster/myads/code?id={{$val->id}}">获取代码</a>
                <a href="/webmaster/myads/edit?id={{$val->id}}">编辑</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection