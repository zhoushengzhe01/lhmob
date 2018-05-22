@extends('webmaster.layout')

@section('content')
<div class="index">
<div class="title"> 管理首页</div>
    <div class="item-index">
        <div class="module userinfo">
            <div class="sumtitle"><i class="fa fa-window-minimize fa-rotate-90" aria-hidden="true"></i> 账户信息</div>
            <div class="sumcon">
                <div class="head"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                <div class="username">
                    <p><a href="/webmaster/user">{{$webmaster->username}}</a></p>
                    <p>上次登录时间：2018-01-01 23:00:34</p>
                </div>
                
            </div>
            <div class="buttom">
                <a href="/webmaster/myads">获取广告</a>
                <a href="/webmaster/money">我的提现</a>
            </div>
        </div>
        <div class="earnings">
            <div class="earnings_con module">
                <div class="sumtitle"><i class="fa fa-window-minimize fa-rotate-90" aria-hidden="true"></i> 收入状况</div>
                <div class="sumcon">
                    <div class="item one">
                        <b>{{$webmaster->hour_money + $webmaster->minute_money}} 元</b>
                        <p>今日收益</p>
                    </div>
                    <div class="item">
                        <b>{{$yesterday_money}} 元</b>
                        <p>昨日收益</p>
                    </div>
                    <div class="item">
                        <b>{{$thisweek_money + $webmaster->hour_money + $webmaster->minute_money}} 元</b>
                        <p>本周收益</p>
                    </div>
                    <div class="item">
                        <b>{{$lastweek_money}} 元</b>
                        <p>上周收益</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="item-index">
        <div class="module chart">
            <div class="sumtitle"><i class="fa fa-window-minimize fa-rotate-90" aria-hidden="true"></i> 收入折线图</div>
            <div class="sumcon">
               
                <!-- 图表容器 DOM -->
                <div id="container" style="width: 100%px; height:400px;"></div>
                <!-- 引入 highcharts.js -->
                <script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
                <script>
                    $(function () {
                        $('#container').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '两周收益报表'
                            },
                            subtitle: {
                                //text: '数据来源: www.lhmob.com'
                            },
                            xAxis: {
                                categories: ['{!! $data !!}'],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '收益（元）'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">&nbsp;{series.name}: &nbsp;</td>' +
                                '<td style="padding:0"><b>&nbsp;{point.y:.2f} 元&nbsp;</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    borderWidth: 0
                                }
                            },
                            series: [
                                @foreach ($earning as $key=>$val)
                                {
                                    name: '{{$val["name"]}}',
                                    data: [{{$val['data']}}]
                                },
                                @endforeach
                            ]
                        });
                    });
                </script>
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
                @foreach ($earningHour as $key=>$val)
                <tr>
                    <td class="t_c">{{$val->ads_name}}</td>
                    <td class="t_c">{{$val->money}} 元</td>
                    <td class="t_c">{{$val->time}}</td>
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>

</div>
@endsection