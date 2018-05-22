@extends('admin.layout')

@section('content')
<div class="title"> 编辑站长</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">登录名称：</td>
                <td class="t_l" width="80%">{{$webmaster->username}} &nbsp;&nbsp;&nbsp;&nbsp; 余额：{{$webmaster->money}}元</td>
            </tr>
            <tr>
                <td class="t_r">真实姓名：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="{{$webmaster->nickname}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">登录密码：</td>
                <td class="t_l"><input type="text" class="text" name="password" size="40" maxlength="100"> <span class="tishi">不填写则不修改</span></td>
            </tr>
            <tr>
                <td class="t_r">电子邮箱：</td>
                <td class="t_l"><input type="text" class="text" name="email" value="{{$webmaster->email}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">联系电话：</td>
                <td class="t_l"><input type="text" class="text" name="mobile" value="{{$webmaster->mobile}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">QQ号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="{{$webmaster->qq}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">允许联盟：</td>
                <td class="t_l"><input type="text" class="text" name="allow_alliance" value="{{$webmaster->allow_alliance}}" size="40" maxlength="100"> <span class="tishi">请选择下面的联盟</span></td>
            </tr>
            <tr>
                <td class="t_r"><?php $allow_alliance = explode(',', $webmaster->allow_alliance); ?></td>
                <td class="t_l">
                @foreach ($alliance as $key=>$val)
                <label> <input name="allow" type="checkbox" value="{{$val->id}}" @if(in_array($val->id, $allow_alliance)) checked @endif/> {{$val->name}} </label>
                @endforeach
                </td>
            </tr>

            <tr>
                <td class="t_r">屏蔽联盟：</td>
                <td class="t_l"><input type="text" class="text" name="disabled_alliance" value="{{$webmaster->disabled_alliance}}" size="40" maxlength="100"> <span class="tishi">请选择下面的联盟</span></td>
            </tr>
            <tr>
                <td class="t_r"><?php $disabled_alliance = explode(',', $webmaster->disabled_alliance); ?></td>
                <td class="t_l">
                @foreach ($alliance as $key=>$val)
                <label> <input name="disabled" type="checkbox" value="{{$val->id}}" @if(in_array($val->id, $disabled_alliance)) checked @endif/> {{$val->name}} </label>
                @endforeach
                </td>
            </tr>
            <tr>
                <td class="t_r">提现类型：</td>
                <td class="t_l">
                    <select name="withdrawals_type">
                        <option value="1" @if($webmaster->withdrawals_type=='1') selected @endif>日结</option>
                        <option value="2" @if($webmaster->withdrawals_type=='2') selected @endif>周结</option>
                    </select>
                    &nbsp;&nbsp; 状态：
                    <select name="state">
                        <option value="1" @if($webmaster->state=='1') selected @endif>正常</option>
                        <option value="2" @if($webmaster->state=='2') selected @endif>被封</option>
                    </select>
                    &nbsp;&nbsp; 域名：
                    <select name="is_limit_domain">
                        <option value="1" @if($webmaster->is_limit_domain=='1') selected @endif>限制</option>
                        <option value="2" @if($webmaster->is_limit_domain=='2') selected @endif>不限制</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">登录时间：</td>
                <td class="t_l">{{$webmaster->login_time}} &nbsp;&nbsp; IP:{{$webmaster->ip}}</td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>
<div class="title"> 银行信息</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">登录名称：</td>
                <td class="t_l" width="80%">{{$webmaster->username}}</td>
            </tr>
            <tr>
                <td class="t_r">真实姓名：</td>
                <td class="t_l"><input type="text" class="text" name="domain" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">登录密码：</td>
                <td class="t_l"><input type="text" class="text" name="icp" size="40" maxlength="100"> </td>
            </tr>
            <tr>
                <td class="t_r">网站分类：</td>
                <td class="t_l">
                    <select name="category_id">
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>

<div class="title"> 站长备注</div>
<div class="content">
    
    <form action="/admin/webmasternote?id={{$webmaster->id}}" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">列表：</td>
                <td class="t_l" width="80%">
                @foreach ($notes as $k=>$v)
                {{$v->created_at}}&nbsp;&nbsp;&nbsp;&nbsp;{{$v->username}}&nbsp;&nbsp;&nbsp;&nbsp;备注：{{$v->note}}  <br/>  
                @endforeach
                </td>
            </tr>
            <tr>
                <td class="t_r" width="20%">备注：</td>
                <td class="t_l" width="80%"><textarea rows="4" cols="40" name="note"></textarea></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>
<br/>
<br/>
<br/>
<br/>
<script>
$('input[name="allow"]').click(function(){

    var checked = '';
    $('input[name="allow"]:checked').each(
        function() {
            checked = checked+","+$(this).val();
        }
    );
    $('input[name="allow_alliance"]').val(checked.substring(1));
});

$('input[name="disabled"]').click(function(){

    var checked = '';
    $('input[name="disabled"]:checked').each(
        function() {
            checked = checked+","+$(this).val();
        }
    );
    $('input[name="disabled_alliance"]').val(checked.substring(1));
});
</script>
@endsection