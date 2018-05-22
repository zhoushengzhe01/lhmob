@extends('admin.layout')

@section('content')
<div class="title"> 网站分类</div>
<div class="tool o_h">
    <a href="/admin/category" class="f_l sm_btn btn_color2">+ 添加分类</a>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="50%"> &nbsp;名称</th>
            <th width="10%">排序</th>
            <th width="10%">状态</th>
            <th width="16%">时间</th>
            <th>操作</th>
        </tr>
        @foreach ($categorys as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->name}}</td>
            <td>{{$val->sort}}</td>
            <td>@if($val->state=='1') <span style="color:green">使用</span> @elseif ($val->state=='2') <span style="color:#ccc">禁止</span> @endif</td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="/admin/category?id={{$val->id}}">编辑</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $categorys->links() !!}
</div>
@endsection