@extends('admin.layout')

@section('content')
<div class="title"> 员工管理</div>
<div class="tool o_h">
    <a href="/admin/user" class="f_l sm_btn btn_color2">+ 添加员工</a>
    <div class="search f_r">
        <form method="get" action="">
            <select name="department_id">
                <option value="0">全部用户</option>
                @foreach ($department as $key=>$val)
                <option value="{{$val->id}}" @if($val->id==$paramet['department_id']) selected @endif>{{$val->name}}</option>
                @endforeach
            </select>
            <input class="text" type="text" name="username" value="{{$paramet['username']}}" placeholder="用户名">
            <input class="text" type="text" name="nickname" value="{{$paramet['nickname']}}" placeholder="真实姓名">
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="10%"> &nbsp;用户名</th>
            <th width="10%">真实姓名</th>
            <th width="10%">部门</th>
            <th width="10%">电话</th>
            <th width="12%">邮箱</th>
            <th width="10%">QQ号</th>
            <th width="10%">登陆IP</th>
            <th width="8%">状态</th>
            <th width="10%">时间</th>
            <th>操作</th>
        </tr>
        @foreach ($users as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->username}}</td>
            <td>{{$val->nickname}}</td>
            <td>{{$val->department_name}}</td>
            <td>{{$val->mobile}}</td>
            <td>{{$val->email}}</td>
            <td>{{$val->qq}}</td>
            <td>{{$val->login_ip}}</td>
            <td>@if ($val->state=='1') 正常 @elseif ($val->state=='2') 关闭 @endif</td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="/admin/user?id={{$val->id}}">编辑</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $users->appends($paramet)->links() !!}
</div>
@endsection