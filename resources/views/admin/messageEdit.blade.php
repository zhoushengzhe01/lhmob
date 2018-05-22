@extends('admin.layout')

@section('content')
<div class="title"> 编辑联盟</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            @if ($message)
            <tr class="top">
                <td class="t_r">公告标题：</td>
                <td class="t_l"><input type="text" class="text" name="title" value="{{$message->title}}" size="60" maxlength="100"></td>
            </tr>
            
            <tr>
                <td class="t_r">是否推荐：</td>
                <td class="t_l">
                    <select name="recommend">
                        <option value="0" @if($message->recommend=='0') selected @endif>否</option>
                        <option value="1" @if($message->recommend=='1') selected @endif>是</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">是否显示：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1" @if($message->state=='1') selected @endif>显示</option>
                        <option value="2" @if($message->state=='2') selected @endif>禁止</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">公告内容：</td>
                <td class="t_l"><textarea rows="10" cols="80" name="content">{{$message->content}}</textarea></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @else
            <tr class="top"> 
                <td class="t_r">标题：</td>
                <td class="t_l"><input type="text" class="text" name="title" value="" size="60" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">是否推荐：</td>
                <td class="t_l">
                    <select name="recommend">
                        <option value="0">否</option>
                        <option value="1">是</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">是否显示：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1">显示</option>
                        <option value="2">禁止</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="t_r">内容：</td>
                <td class="t_l"><textarea rows="10" cols="80" name="content"></textarea></td>
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