@extends('admin.layout')

@section('content')
<div class="title"> 添加/编辑分类</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            @if ($category)
            <tr class="top">
                <td class="t_r">分类名称：</td>
                <td class="t_l"><input type="text" class="text" name="name" value="{{$category->name}}" size="40" maxlength="100"></td>
            </tr>
            
            <tr>
                <td class="t_r">分类排序：</td>
                <td class="t_l"><input type="text" class="text" name="sort" value="{{$category->sort}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1" @if($category->state=='1') selected @endif>使用</option>
                        <option value="2" @if($category->state=='2') selected @endif>禁止</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color2" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
            @else
            <tr class="top">
                <td class="t_r">分类名称：</td>
                <td class="t_l"><input type="text" class="text" name="name" size="40" maxlength="100"></td>
            </tr>
            
            <tr>
                <td class="t_r">分类排序：</td>
                <td class="t_l"><input type="text" class="text" name="sort" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1">使用</option>
                        <option value="2">禁止</option>
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