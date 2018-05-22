@extends('webmaster.layout')

@section('content')

<div class="title"> 获取广告代码</div>

<div class="prompt">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
    加载广告时，请勿使用任何包含"ad"等与广告有关字眼的js目录、js文件名称、样式层变量名称和js函数方法。
</div>

<div class="content">
    
    <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
    <tbody>
        <tr class="top">
            <td class="t_r" width="120">广告名称：</td>
            <td class="t_l">{{$myads->name}}</td>
        </tr>
        <tr>
            <td class="t_r">广告类型：</td>
            <td class="t_l">{{$myads->position_name}}</td>
        </tr>
        <tr>
            <td class="t_r">计费类型：</td>
            <td class="t_l">{{$myads->billing}}</td>
        </tr>
        <tr>
            <td class="t_r">HTML代码：</td>
            <td class="t_l">
                <a href="javascript:void(0)" class="sm_btn btn_color1 f_l" id="html_http">&nbsp;http&nbsp;</a>
                <a href="javascript:void(0)" class="sm_btn btn_color f_l t_c" id="html_https">https</a>
            </td>
        </tr>
        <tr>
            <td class="t_r"></td>
            <td class="t_l">
                <textarea style="width: 531px;height: 145px;border: 1px solid #ccc;" id="html_code"><script>;(function() { var body = document.getElementsByTagName('body')[0]; var script = document.createElement('script'); script.type = 'text/javascript'; script.src = "http://{{$url}}/{{$myads->id}}?time=" + Math.random(); body.appendChild(script); })();</script></textarea>
            </td>
        </tr>
        <tr>
            <td class="t_r">JS代码：</td>
            <td class="t_l">
                <a href="javascript:void(0)" class="sm_btn btn_color1 f_l" id="js_http">&nbsp;http&nbsp;</a>
                <a href="javascript:void(0)" class="sm_btn btn_color f_l t_c" id="js_https">https</a>
            </td>
        </tr>
        <tr>
            <td class="t_r"></td>
            <td class="t_l">
            <textarea style="width: 531px;height: 145px;border: 1px solid #ccc" id="js_code">;(function() { var body = document.getElementsByTagName('body')[0]; var script = document.createElement('script'); script.type = 'text/javascript'; script.src = "http://{{$url}}/{{$myads->id}}?time=" + Math.random(); body.appendChild(script); })();</textarea></td>
        </tr>

    </tbody>
    </table>
</div>
<script>
$("#html_http").click(function(){
    $(this).attr('class', 'sm_btn btn_color1 f_l t_c');
    $("#html_https").attr('class', 'sm_btn btn_color f_l t_c');

    var code = $("#html_code").val();
    $("#html_code").val(code.replace("https", "http"));
});

$("#html_https").click(function(){
    $(this).attr('class', 'sm_btn btn_color1 f_l t_c');
    $("#html_http").attr('class', 'sm_btn btn_color f_l t_c');

    var code = $("#html_code").val();
    $("#html_code").val(code.replace("http", "https"));
});


$("#js_http").click(function(){
    $(this).attr('class', 'sm_btn btn_color1 f_l t_c');
    $("#js_https").attr('class', 'sm_btn btn_color f_l t_c');

    var code = $("#js_code").val();
    $("#js_code").val(code.replace("https", "http"));
});

$("#js_https").click(function(){
    $(this).attr('class', 'sm_btn btn_color1 f_l t_c');
    $("#js_http").attr('class', 'sm_btn btn_color f_l t_c');

    var code = $("#js_code").val();
    $("#js_code").val(code.replace("http", "https"));
});

</script>
@endsection