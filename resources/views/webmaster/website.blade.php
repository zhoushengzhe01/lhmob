@extends('webmaster.layout')

@section('content')
<div class="title"> 我的网站</div>
<div class="tool o_h">
    <a href="/webmaster/website/add" class="f_l sm_btn btn_color1">+ 添加网站</a>
    <div class="search f_r">
        <form method="get" >
            <input class="text" type="text" name="keyword" value="" placeholder="网站域名搜索">
            <input class="sm_btn btn_color" type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="12%">网站名称</th>
            <th width="12%">网站域名</th>
            <th width="10%">网站类型</th>
            <th width="18%">备案号</th>
            <th width="12%">状态</th>
            <th width="20%">审核时间</th>
            <th width="10%" class="t_c">操作</th>
        </tr>
        @foreach ($mywebsite as $key=>$val)
        <tr>
            <td>{{$val->name}}</td>
            <td>{{$val->domain}}</td>
            <td>{{$val->category_name}}</td>
            <td>{{$val->icp}}</td>
            <td>@if ($val->state==0) <span style="color:red;">等待审核</span> @elseif ($val->state==1) <span style="color:green;">审核通过</span> @elseif ($val->state==2) <span style="color:#999;">拒绝</span> @endif</td>
            <td>{{$val->updated_at}}</td>
            <td class="t_c"><a href="/webmaster/website/edit?id={{$val->id}}">编辑</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection