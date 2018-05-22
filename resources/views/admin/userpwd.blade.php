@extends('admin.layout')

@section('content')
<div class="title"> 编辑联盟</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r">旧密码：</td>
                <td class="t_l"><input type="text" class="text" name="oldpasswd" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">新密码：</td>
                <td class="t_l"><input type="text" class="text" name="newpasswd" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">确认密码：</td>
                <td class="t_l"><input type="text" class="text" name="newpasswd1" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>
@endsection