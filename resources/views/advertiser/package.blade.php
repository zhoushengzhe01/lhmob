@extends('advertiser.layout')

@section('content')
<div class="title"> 添加素材</div>
<div class="content">
    <!--添加-->
    <form action="" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="" class="from">
        <tbody>
            <tr class="top">
                <td class="t_r" width="20%">素材名称</td>
                <td class="t_l"><input type="text" class="text" name="company" value="{{$group['advertiser']->company}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">投放类型：</td>
                <td class="t_l"><input type="text" class="text" name="nickname" value="{{$group['advertiser']->nickname}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td class="t_r">上传图片：</td>
                <td class="t_l">
                    <button type="button" class="btn btn-info">选择图片</button> <span class="tishi"><b>*</b>&nbsp;&nbsp;图片尺寸：<span class="size2">640 * 100</span></span>
                    <input type="text" class="text" name="picture1">
                    <div class="pictures">
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="t_r">上传图片：</td>
                <td class="t_l">
                    <button type="button" class="btn btn-info">选择图片</button> <span class="tishi"><b>*</b>&nbsp;&nbsp;图片尺寸：<span class="size2">640 * 150</span></span>
                    <input type="text" class="text" name="picture2">
                    <div class="pictures">
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="t_r">上传图片：</td>
                <td class="t_l">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">选择图片</button> <span class="tishi"><b>*</b>&nbsp;&nbsp;图片尺寸：<span class="size2">640 * 200</span></span>
                    <input type="text" class="text" name="picture3">
                    <div class="pictures">
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                        <span id=""><img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" height="60"/></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="t_r">QQ号码：</td>
                <td class="t_l"><input type="text" class="text" name="qq" value="{{$group['advertiser']->qq}}" size="40" maxlength="100"></td>
            </tr>
            <tr>
                <td>{!! csrf_field() !!}</td>
                <td class="t_l"><input type="submit" class="sm_btn btn_color1" name="submit" id="submit" value="&nbsp;&nbsp;保 存&nbsp;&nbsp;"></td>
            </tr>
        </tbody>
        </table>
    </form>
</div>


<form id="fileupload-form">    
     <input id="fileupload" type="file" name="file" >   
</form>


<script> 
$('#fileupload-form').on('submit',(function(e) {
    e.preventDefault();
    // 序列化表单   
    var serializeData = $(this).serialize();

    // var formData = new FormData(this);
    $(this).ajaxSubmit({
        type:'POST',
        url: 'http://lhmob.dev/aaa.php',
        dataType: 'json', 
        data: serializeData,            
        // data: formData,
       
        //attention!!!   
        contentType: false,      
        cache: false,             
        processData:false,      
         
        beforeSubmit: function() {
            //上传图片之前的处理   
        },
        uploadProgress: function (event, position, total, percentComplete){ 
            //在这里控制进度条   
        },
        success:function(){

        },
        error:function(data){
            alert('上传图片出错');
        }
    });
}));

$("#fileupload").on("change", function() {
    $(this).parent().submit();
});
</script>




<!-- 按钮：用于打开模态框 -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
    打开模态框
</button>
<!-- 模态框 -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- 模态框头部 -->
            <div class="modal-header">
                <h4 class="modal-title">上传图片</h4>
                <button type="button" class="btn btn-outline-info">选择图片</button>
            </div>
            <!-- 模态框主体 -->
            <div class="modal-body">
                <div class="left">
                    <ul>
                        <li>
                    </ul>
                </div>
                <div class="right">
                    <ul class="img_list">
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="122.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li data-url="123.jpg">
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    <li>
                        <div class="image">
                            <img src="http://img.xcy8.com/union/mobile/creative/slave/2018/03/19287/1521097147728.gif" width="100%" height="100%">
                            <div class="delete"><i class="fa fa-close" aria-hidden="true"></i></div>
                            <div class="icon"></div>
                        </div>
                    </li>
                    </ul>
                </div>
            </div>
            <!-- 模态框底部 -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="confirm" data-dismiss="modal"> &nbsp;确&nbsp;定&nbsp; </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> &nbsp;关&nbsp;闭&nbsp; </button>
            </div>
   
        </div>
    </div>
    <script>
        //鼠标滑过
        $(".img_list li").mouseover(function(){
            $(this).addClass('action');
        });
        $(".img_list li").mouseout(function(){
            $(this).removeClass('action');
        });
        
        //点击选中
        $(".img_list li").click(function(){

            if( $(this).hasClass('select') )
            {
                $(this).removeClass('select');
                $(this).removeClass('action');
            }
            else
            {
                $(this).addClass('select');
            }
        });

        //确定按钮
        $("#confirm").click(function(){
            $(".select").each(function()
            {
                alert($(this).data('url'));
            });
        });
    </script>
</div>
@endsection