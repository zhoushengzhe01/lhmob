@extends('admin.layout')

@section('content')
<div class="title"> 网站管理</div>
<div class="tool o_h">
    <a href="/admin/website" class="f_l sm_btn btn_color2">+ 添加网站</a>
    <div class="search f_r">
        <form method="get">
            <select name="category_id">
                <option value="">所有网站</option>
                @foreach ($websiteCategory as $key=>$val)
                <option value="{{$val->id}}" @if($val->id==$paramet['category_id']) selected @endif>{{$val->name}}</option>
                @endforeach
            </select>
            <input class="text" type="text" name="webmaster_id" value="{{$paramet['webmaster_id']}}" placeholder="站长ID">
            <input class="text" type="text" name="domain" value="{{$paramet['domain']}}" placeholder="域名搜索">
            <input type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="8%"> &nbsp;站长ID</th>
            <th width="12%">网站名称</th>
            <th width="12%">网站域名</th>
            <th width="10%">网站类型</th>
            <th width="18%">备案号</th>
            <th width="12%">状态</th>
            <th width="20%">审核时间</th>
            <th class="t_l">操作</th>
        </tr>
        @foreach ($websites as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td>{{$val->name}}</td>
            <td>{{$val->domain}}</td>
            <td>{{$val->category_name}}</td>
            <td>{{$val->icp}}</td>
            <td>@if ($val->state==0) <span style="color:red;">等待审核</span> @elseif ($val->state==1) <span style="color:green;">审核通过</span> @elseif ($val->state==2) <span style="color:#999;">拒绝</span> @endif</td>
            <td>{{$val->updated_at}}</td>
            <td class="t_l"><a href="/admin/website?id={{$val->id}}">编辑</a></td>
        </tr>
        @endforeach
    </table>

    {!! $websites->appends($paramet)->links() !!}
</div>
@endsection