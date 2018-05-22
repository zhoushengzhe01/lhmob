@extends('admin.layout')

@section('content')
<div class="title"> 广告联盟</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="140"> &nbsp;名称</th>
            <th width="80">广告位</th>
            <th width="80">位置</th>
            <th width="80">次数</th>
            <th width="260">联盟账号</th>
            <th width="80">状态</th>
            <th width="80">价格</th>
            <th width="200">创建时间</th>
            <th>操作</th>
        </tr>
        @foreach ($alliances as $key=>$val)
        <tr>
            <td> &nbsp;<a href="{{$val->login_url}}" target="_blank">{{$val->name}}</a></td>
            <td>{{$val->position_name}}</td>
            <td>
                @if ($val->position=='1')
                顶部
                @elseif ($val->position=='2')
                底部
                @elseif ($val->position=='3')
                左边
                @elseif ($val->position=='4')
                右边
                @else
                <span style="color:#ccc">无位置</span>
                @endif
            </td>
            <td>{{$val->record_num}} 次</td>
            <td>账号：{{$val->account}} <br>密码：{{$val->password}}</td>
            <td>@if ($val->state=='1') <span style="color:#00ba8b">使用</span> @else <span style="color:#ccc">停止</span> @endif</td>
            <td>{{$val->price}} 元</td>
            <td>{{$val->created_at}}</td>
            <td>
                <a href="/admin/alliance?id={{$val->id}}">编辑</a>&nbsp;
                <a href="/admin/alliance/hour?alliance_id={{$val->id}}">支出</a>&nbsp;
            </td>
        </tr>
        @endforeach
    </table>

    {!! $alliances->links() !!}
</div>
@endsection