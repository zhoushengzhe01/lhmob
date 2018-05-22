@extends('admin.layout')

@section('content')
<div class="title"> 系统设置</div>
<div class="content">
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r">网站标题：</td>
                <td class="t_l"><input type="text" class="text" name="title" value="{{$setting->title}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">域名：</td>
                <td class="t_l"><input type="text" class="text" name="domain" value="{{$setting->domain}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">地址：</td>
                <td class="t_l"><input type="text" class="text" name="url" value="{{$setting->url}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">SEO标题：</td>
                <td class="t_l"><input type="text" class="text" name="seo_title" value="{{$setting->seo_title}}" size="80" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">SEO关键词：</td>
                <td class="t_l"><textarea rows="5" cols="62" name="seo_keywords">{{$setting->seo_keywords}}</textarea></td>
            </tr>
            <tr>
                <td class="t_r">SEO描述：</td>
                <td class="t_l"><textarea rows="5" cols="62" name="seo_description">{{$setting->seo_description}}</textarea></td>
            </tr>
            <tr>
                <td class="t_r">public地址：</td>
                <td class="t_l"><input type="text" class="text" name="public" value="{{$setting->public}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">广告域名：</td>
                <td class="t_l"><input type="text" class="text" name="ad_domain" value="{{$setting->ad_domain}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">状态：</td>
                <td class="t_l">
                    <select name="state">
                        <option value="1" @if($setting->state=='1') selected @endif>正常</option>
                        <option value="2" @if($setting->state=='2') selected @endif>关闭</option>
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
@endsection