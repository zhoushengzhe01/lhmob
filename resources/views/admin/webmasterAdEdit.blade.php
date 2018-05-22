@extends('admin.layout')

@section('content')
<div class="title"> 编辑广告位</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">广告名称：</td>
                <td class="t_l" width="80%"><input type="text" class="text" name="name" value="{{$webmasterAd->name}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">广告类型：</td>
                <td class="t_l">
                    @foreach ($adsPosition as $key=>$val)
                    <label onclick="click_adstype('{{$val->id}}')"><input type="radio" name="position_id" @if ($val->id==$webmasterAd->position_id) checked @endif value="{{$val->id}}">{{$val->name}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </td>
            </tr>
            <tr id="position" @if ($webmasterAd->position_id!=11) style="display: none;" @endif>
                    <td class="t_r">广告位置：</td>
                    <td class="t_l">
                        <label><input type="radio" @if ($webmasterAd->position==1) checked @endif name="position" value="1">顶浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input type="radio" @if ($webmasterAd->position==2) checked @endif name="position" value="2">底浮</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            <tr>
                <td class="t_r">计费方式：</td>
                <td class="t_l">
                    <label><input type="radio" @if ($webmasterAd->billing=='CPC') checked @endif name="billing" value="CPC">CPC</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" @if ($webmasterAd->billing=='CPM') checked @endif name="billing" value="CPM">CPM</label>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td class="t_r">计费率：</td>
                <td class="t_l"><input type="text" class="text" name="price" value="{{$webmasterAd->price}}" size="10" maxlength="100"> %</td>
            </tr>
            <tr>
                <td class="t_r">是否顶部：</td>
                <td class="t_l">
                    <label><input type="radio" @if ($webmasterAd->is_top==1) checked @endif name="is_top" value="1">是</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" @if ($webmasterAd->is_top==0) checked @endif name="is_top" value="0">否</label>&nbsp;&nbsp;&nbsp;&nbsp;
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