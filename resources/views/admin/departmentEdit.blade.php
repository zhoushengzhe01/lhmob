@extends('admin.layout')

@section('content')
<div class="title"> 添加/编辑部门</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            @if ($department)
            <tr class="top">
                <td class="t_r">名称：</td>
                <td class="t_l"><input type="text" class="text" name="name" value="{{$department->name}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1" @if($department->state=='1') selected @endif>正常</option>
                        <option value="2" @if($department->state=='2') selected @endif>关闭</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn 2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @else
            <tr class="top">
                <td class="t_r">名称：</td>
                <td class="t_l"><input type="text" class="text" name="name" value="" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1">正常</option>
                        <option value="2">关闭</option>
                    </select>
                </td>
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