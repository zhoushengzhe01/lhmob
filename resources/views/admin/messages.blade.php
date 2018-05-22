@extends('admin.layout')

@section('content')
<div class="title"> 广告联盟</div>
<div class="tool o_h">
    <a href="/admin/message" class="f_l sm_btn btn_color2">+ 添加公告</a>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="50%"> &nbsp;标题</th>
            <th width="8%">是否推荐</th>
            <th width="8%">状态</th>
            <th width="18%">时间</th>
            <th>操作</th>
        </tr>
        @foreach ($messages as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->title}}</td>
            <td>@if ($val->recommend=='0') 否 @elseif ($val->recommend=='1') 是 @endif</td>
            <td>@if ($val->state=='1') 展示 @elseif ($val->state=='2') 禁止 @endif</td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="/admin/message?id={{$val->id}}">编辑</a>&nbsp;
                <a href="">支出</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $messages->links() !!}
</div>
@endsection