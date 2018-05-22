@extends('admin.layout')

@section('content')
<div class="title"> 添加/编辑奖励</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            
            @if ($reward)
            <tr class="top">
                <td class="t_r" width="20%">站长名字：</td>
                <td class="t_l" width="80%">{{$reward->username}}</td>
            </tr>
            <tr>
                <td class="t_r">站长ID：</td>
                <td class="t_l"><input type="text" class="text" name="webmaster_id" value="{{$reward->webmaster_id}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">金额：</td>
                <td class="t_l"><input type="text" class="text" name="money" value="{{$reward->money}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">说明：</td>
                <td class="t_l"><input type="text" class="text" name="note" value="{{$reward->note}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @else
            <tr class="top">
                <td class="t_r">站长ID：</td>
                <td class="t_l"><input type="text" class="text" name="webmaster_id" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">金额：</td>
                <td class="t_l"><input type="text" class="text" name="money" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">说明：</td>
                <td class="t_l"><input type="text" class="text" name="note" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @endif
        </tbody>
        </table>
    </form>
</div>
@endsection