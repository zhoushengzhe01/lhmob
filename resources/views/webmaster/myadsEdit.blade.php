@extends('webmaster.layout')

@section('content')

<div class="title"> 编辑/添加广告位</div>

<div class="prompt">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
    禁止淫秽、色情、赌博、暴力或者教唆犯罪等违反国家法律、法规的网站投放本联盟代码，一经发现，将立即做封号处理。
</div>

<div class="content">
    
    <!--添加-->
    @if ($action=='add')
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">广告名称：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="name" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">广告类型：</td>
                <td class="t_l">
                    @foreach ($adsposition as $key=>$val)
                        <label @if ($val->state=='0') style="color:#ccc" @else onclick="click_adstype('{{$val->id}}')" @endif>
                        <input type="radio" name="position_id" value="{{$val->id}}" @if ($val->state=='0') disabled @else checked @endif> {{$val->name}} </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </td>
            </tr>
            <tr id="position">
                <td class="t_r">广告位置：</td>
                <td class="t_l">
                    <label><input type="radio" name="position" value="2" checked>底浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="position" value="1">顶浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td class="t_r">计费方式：</td>
                <td class="t_l">
                    <label><input type="radio" name="billing" value="CPM" checked>CPM</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="color:#ccc"><input type="radio" name="billing" disabled value="CPC">CPC</label>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
    @endif
    <!--修改-->
    @if ($action=='edit')
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">广告名称：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="name" value="{{$myads->name}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">广告类型：</td>
                <td class="t_l">
                    @foreach ($adsposition as $key=>$val)
                    <label onclick="click_adstype('{{$val->id}}')"><input type="radio" name="position_id" @if ($val->id==$myads->position_id) checked @endif value="{{$val->id}}">{{$val->name}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </td>
            </tr>
            <tr id="position" @if ($myads->position_id!=11) style="display: none;" @endif>
                    <td class="t_r">广告位置：</td>
                    <td class="t_l">
                        <label><input type="radio" @if ($myads->position==1) checked @endif name="position" value="1">顶浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input type="radio" @if ($myads->position==2) checked @endif name="position" value="2">底浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            <tr>
                <td class="t_r">计费方式：</td>
                <td class="t_l">
                    <label><input type="radio" @if ($myads->billing=='CPC') checked @endif name="billing" value="CPC">CPC</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" @if ($myads->billing=='CPM') checked @endif name="billing" value="CPM">CPM</label>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
    @endif
</div>
<script>
function click_adstype(Id)
{
    if(Id=='11')
    {
        $("#position").show();
    }
    else
    {
        $("#position").hide();
    }
}
</script>
@endsection