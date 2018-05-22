@extends('admin.layout')

@section('content')
<div class="title"> 部门管理</div>
<div class="tool o_h">
    <span class="f_l sm_btn btn_color2">+ 添加部门</span>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="10%"> &nbsp; ID</th>
            <th width="25%">名称</th>
            <th width="25%">状态</th>
            <th width="25%">时间</th>
            <th>操作</th>
        </tr>
        @foreach ($departments as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->id}}</td>
            <td>{{$val->name}}</td>
            <td>@if ($val->state=='1') 正常 @elseif ($val->state=='2') 禁止 @endif</td>
            <td>{{$val->created_at}}</td>
            <td><a href="/admin/users/department/edit?id={{$val->id}}">编辑</a></td>
        </tr>
        @endforeach
    </table>

    {!! $departments->links() !!}
</div>
@endsection