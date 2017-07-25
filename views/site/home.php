<?php


use yii\helpers\Url;
$this->title = '阿凡达管理平台';
?>
<style>
ul.count_box{
    overflow: hidden;
    margin:20px 0;
}
ul.count_box li{
    float: left;
    width: 25%;
    text-align: center;
}
ul.count_box li .title{
    font-size: 14px;
    color: #333;
    margin-top: 0;
}
ul.count_box li .number{
    font-size: 24px;
    display: block;
    color: #333;
}
ul.count_box li p{
    margin-bottom: 0;
    color: #999;
    margin-top: 10px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning" role="alert">注：如果权限不够，请联系管理员开通权限。</div>

        <!-- 总数 -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    今日数据
                    <span data-toggle="popover"
                          class="glyphicon glyphicon-question-sign color-gray text-sm js-today-data-popover"
                          data-original-title="" title=""></span>
                </h3>
            </div>
            <div class="panel-body">
                <ul class="count_box">
                    <li>
                        <div class="title">新增订单</div>
                        <span class="number" id="orderToday">0</span>
                        <p>总数: <span id="orderCount">0</span></p>
                    </li>
                    <li style="border-left:1px solid #eee">
                        <div class="title">新增发货人</div>
                        <span class="number" id="shipperToday">0</span>
                        <p>总数: <span id="shipperCount">0</span></p>
                    </li>
                    <li style="border-left:1px solid #eee">
                        <div class="title">新增司机</div>
                        <span class="number" id="driverToday">0</span>
                        <p>总数: <span id="driverCount">0</span></p>
                    </li>
                    <li style="border-left:1px solid #eee">
                        <div class="title">新增合伙人</div>
                        <span class="number" id="hhrToday">0</span>
                        <p>总数: <span id="hhrCount">0</span></p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding-bottom:16px;">
                        <div class="pull-right">
                            <span class="mrl text-sm js-data-switch-time" id="order_section">2017-07-02~2017-07-08</span>
                            <div class="btn-group btn-group-xs">
                                <button type="button"
                                        data-type="7"
                                        class="order_section_btn btn btn-primary">最近7天
                                </button>
                                <button type="button"
                                        data-type="30"
                                        class="order_section_btn btn btn-default">最近30天
                                </button>
                            </div>
                        </div>
                        <h3 class="panel-title">订单统计</h3>
                    </div>
                    <div class="panel-body">
                        <div id="order_data" style="height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding-bottom:16px;">
                        <div class="pull-right">
                            <span class="mrl text-sm js-data-switch-time" id="user_section">2017-07-02~2017-07-08</span>
                            <div class="btn-group btn-group-xs">
                                <button type="button"
                                        data-type="7"
                                        class="btn btn-primary user_section_btn">最近7天
                                </button>
                                <button type="button"
                                        data-type="30"
                                        class="btn btn-default user_section_btn">最近30天
                                </button>
                            </div>
                        </div>
                        <h3 class="panel-title">用户统计</h3>
                    </div>

                    <div class="panel-body">
                        <div id="user_data" style="height:400px;">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/plugins/echarts/echarts.common.min.js"></script>
<script>
var userOption =  {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} 人"
    },
    legend: {
        orient: 'vertical',
        x: 'left',
        data:['司机', '发货人']
    },
    color:['#F40355', '#00F500'],
    series: [{
        name:'用户统计',
        type:'pie',
        radius: ['50%', '70%'],
        avoidLabelOverlap: false,
        label: {
            normal: {
                show: false,
                position: 'center'
            },
            emphasis: {
                show: true,
                textStyle: {
                    fontSize: '30',
                    fontWeight: 'bold'
                }
            }
        },
        labelLine: {
            normal: {
                show: false
            }
        },
        data:[]
    }]
};
var orderOption = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} 笔"
    },
    xAxis:  {
        type: 'category',
        boundaryGap: false,
        data: []
    },
    yAxis: {
        type: 'value',
        axisLabel: {
            formatter: '{value}'
        }
    },
    color: ['#00A3A3'],
    series: [
        {
            name:'订单数',
            type:'line',
            data:[],
            markPoint: {
                data: [
                    {type: 'max', name: '最大值'},
                    {type: 'min', name: '最小值'}
                ]
            },
            markLine: {
                data: [
                    {type: 'average', name: '平均值'}
                ]
            }
        }
    ]
};
var userObj, orderObj;
window.onload = function() {
    $('#user_data').css('width', $('#user_data').width() + 'px');
    $('#order_data').css('width', $('#order_data').width() + 'px');

    var userDom = document.getElementById('user_data');
    var orderDom = document.getElementById('order_data');
    userObj = echarts.init(userDom);
    orderObj = echarts.init(orderDom);

    // 用户
    $('.user_section_btn').click(function() {
        var type = $(this).attr('data-type');

        $('.user_section_btn').removeClass('btn-primary').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-primary');

        getSectionUser(type);
    });

    // 订单
    $('.order_section_btn').click(function() {
        var type = $(this).attr('data-type');

        $('.order_section_btn').removeClass('btn-primary').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-primary');

        getSectionOrder(type);
    });

    getSectionOrder(7);
    getSectionUser(7);
    APP.post("<?= Url::toRoute('site/get-home-data') ?>", { }, function(res) {
        if (res !== false) {
            $('#orderCount').html(res.orderCount);
            $('#shipperCount').html(res.shipperCount);
            $('#driverCount').html(res.driverCount);
            $('#hhrCount').html(res.hhrCount);

            $('#orderToday').html(res.orderTodayCount);
            $('#shipperToday').html(res.shipperTodayCount);
            $('#driverToday').html(res.driverTodayCount);
            $('#hhrToday').html(res.hhrTodayCount);
        }
    });
}

// 获取区间订单
function getSectionOrder(day) {
    APP.post("<?= Url::toRoute('site/get-home-section-order') ?>", {
        day : day
    }, function(res) {
        if (res !== false) {
            // 处理订单
            orderOption.xAxis.data = res.title;
            orderOption.series[0].data = res.data;

            $('#order_section').html(res.section);
            orderObj.setOption(orderOption);
        }
    });
}

// 获取区间用户
function getSectionUser(day) {
    APP.post("<?= Url::toRoute('site/get-home-section-user') ?>", {
        day: day
    }, function(res) {
        if (res !== false) {
            userOption.series[0].data = [
                {value:res.driver, name:'司机'},
                {value:res.shipper, name:'发货人'}
            ];

            $('#user_section').html(res.section);
            userObj.setOption(userOption);
        }
    });
}
</script>

<?php $this->beginBlock('test') ?>

<?php $this->endBlock()?>
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>