<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">

        <style>
            .container {
                margin: 0 auto;
                width: 96%;
                max-width: 500px;
                margin-top: 14%;
            }
            .modal-footer{
                border-top: 1px solid #d9edf7;
                padding: 6px 15px;
            }
            .panel-body{
                text-align: center;
                line-height: 40px;
                color: green;
            }
            .panel-body .message{
                font-size: 16px;
                font-size:18px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-check" aria-hidden="true"></i> 提示信息</h3>
                </div>
                <div class="panel-body">
                    <p class="message"><i class="fa fa-check-circle-o" aria-hidden="true" style="font-size:20px;"></i> {{$message}}</p>
                    <p class="skip"><span id="time">3</span> 秒后跳转，如果没跳转点击  
                    @if ($url=='-1')
                    <a href="javascript:void(0)" onclick="window.history.back(-1);">直接进入</a>
                    @else
                    <a href="{{$url}}">直接进入</a>
                    @endif
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-info btn-sm">返回首页</a>
                    @if ($url=='-1')
                    <a href="javascript:void(0)" onclick="window.history.back(-1);" class="btn btn-info btn-sm">直接进入</a>
                    @else
                    <a href="{{$url}}" class="btn btn-info btn-sm">直接进入</a>
                    @endif
                    
                </div>
            </div>
        </div>
            
        <script>
            var time = 3;
            setInterval(function() {
                time = time-1;
                document.getElementById("time").innerHTML = time;
                if(time<1)
                {
                    @if ($url=='-1')
                    window.history.back(-1);
                    @else
                    window.location.href="{{$url}}"; 
                    @endif
                }
            }, 1000)
        </script>        
    </body>
</html>