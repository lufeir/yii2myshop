<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>WeUI</title>
    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
</head>
<body>
<div class="page">
    <div class="page__hd">
        <h1 class="page__title">我的订单</h1>
        <p class="page__desc">列表</p>
    </div>
    <div class="page__bd">
        <div class="weui-cells__title">订单列表</div>
        <div class="weui-cells">
            <?php foreach($orders as $order):?>
                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__hd"></div>
                    <div class="weui-cell__bd">
                        <p><?=$order->name?></p>
                    </div>
                    <div class="weui-cell__ft"><?='总计金额'.$order->total?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="page__ft">
        <a href="javascript:home()"><img src="./images/icon_footer_link.png" /></a>
    </div>
</div>
</body>
</html>