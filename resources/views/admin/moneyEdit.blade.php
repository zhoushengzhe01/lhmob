@extends('admin.layout')

@section('content')
<div class="title"> 编辑联盟</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">站长名称：</td>
                <td class="t_l" width="80%">{{$money->username}} &nbsp; @if ($money->type=='1') 日结 @elseif ($money->type=='2') 周结 @endif </td>
            </tr>
            <tr>
                <td class="t_r">银行名称：</td>
                <td class="t_l"><input type="text" class="text" name="bank_name" value="{{$money->bank_name}}" size="40" maxlength="100"> <span class="tishi">不建议后台修改</div></td>
            </tr>
            <tr>
                <td class="t_r">所在支行：</td>
                <td class="t_l"><input type="text" class="text" name="bank_branch" value="{{$money->bank_branch}}" size="40" maxlength="100"> <span class="tishi">不建议后台修改</div></td>
            </tr>
            <tr>
                <td class="t_r">银行卡号：</td>
                <td class="t_l"><input type="text" class="text" name="bank_card" value="{{$money->bank_card}}" size="40" maxlength="100"> <span class="tishi">不建议后台修改</div></td>
            </tr>
            <tr>
                <td class="t_r">收款人名：</td>
                <td class="t_l"><input type="text" class="text" name="bank_account" value="{{$money->bank_account}}" size="40" maxlength="100"> <span class="tishi">不建议后台修改</div></td>
            </tr>
            <tr>
                <td class="t_r">提现金额：</td>
                <td class="t_l"><input type="text" class="text" name="money" value="{{$money->money}}" size="10" maxlength="100"> <span class="tishi">元</div></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                <select name="state">
                    <option value="1" @if($money->state=='1') selected @endif>未结算</option>
                    <option value="2" @if($money->state=='2') selected @endif>已结算</option>
                    <option value="3" @if($money->state=='3') selected @endif>拒接</option>
                </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">拒接理由：</td>
                <td class="t_l"><textarea rows="5" cols="40" name="message">{{$money->message}}</textarea></td>
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