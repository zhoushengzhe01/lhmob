@extends('admin.layout')

@section('content')
<div class="title"> 登录日志</div>
<div class="tool o_h">
    <a href="#" class="f_l sm_btn btn_color2">+ 添加网站</a>
    <div class="search f_r" style="width: 260px;">
        <form method="get" action="">
            <input class="text" type="text" name="webmaster_id" value="{{$paramet['webmaster_id']}}" placeholder="站长ID">
            <input class="sm_btn btn_color" type="submit" value="查 询">
        </form>
    </div>
</div>
<div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
        <tr>
            <th width="10%"> &nbsp;站长ID</th>
            <th width="45%" class="t_c">登录IP</th>
            <th width="45%" class="t_c">登录时间</th>
        </tr>
        @foreach ($loginlogs as $key=>$val)
        <tr>
            <td> &nbsp;{{$val->webmaster_id}}</td>
            <td class="t_c">{{$val->login_ip}}</td>
            <td class="t_c">{{$val->created_at}}</td>
        </tr>
        @endforeach
    </table>

    {!! $loginlogs->appends($paramet)->links() !!}
</div>
@endsection