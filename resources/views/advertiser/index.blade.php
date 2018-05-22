@extends('advertiser.layout')

@section('content')
<div class="index">
<div class="title"> 管理首页</div>
    <div class="item-index">
        <div class="module userinfo">
            <div class="sumtitle"><i class="fa fa-window-minimize fa-rotate-90" aria-hidden="true"></i> 账户信息</div>
            <div class="sumcon">
                <div class="head"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                <div class="username">
                    <p><a href="/webmaster/user"></a></p>
                    <p>上次登录时间：2018-01-01 23:00:34</p>
                </div>
                
            </div>
            <div class="buttom">
                <a href="/webmaster/myads">获取广告</a>
                <a href="/webmaster/money">我的提现</a>
            </div>
        </div>

    </div>

    <div class="item-index">
        <div class="module chart">
            <div class="sumtitle"><i class="fa fa-window-minimize fa-rotate-90" aria-hidden="true"></i> 收入折线图</div>
            <div class="sumcon">
               

            </div>
        </div>
    </div>
    <div class="item-index">
        <div class="module chart">
            <div class="sumtitle"><i class="fa fa-window-minimize fa-rotate-90" aria-hidden="true"></i> 收益详情</div>
            <div class="sumcon">
                <table width="100%" border="0" cellspacing="0" cellpadding="" style="">
                <tr>
                    <th width="20%" class="t_c">广告</th>
                    <th width="40%" class="t_c">金额</th>
                    <th width="40%" class="t_c">时间</th>
                </tr>
                
                </table>
            </div>
        </div>
    </div>

</div>
@endsection