<table class="table table-bordered table-responsive">
    <tr>
        <th width="10%">订单号</th>
        <th width="20%">订单商品</th>
        <th width="10%">收货人</th>
        <th width="20%">订单金额</th>
        <th width="20%">下单时间</th>
        <th width="10%">订单状态</th>
        <th width="10%">操作</th>
    </tr>
<?php foreach ($models as $order){?>
    <?php foreach ($order->ogoods as $content):?>
        <tr>
            <td><a href=""><?=$order->id.rand(1000,9999)?></a></td>
            <td><a href=""><?= \yii\helpers\Html::img('http://admin.yii2shop.com/'.$content->logo,['width'=>80])?></a></td>
            <td><?=$order->name?></td>
            <td>￥<?=$content->total?> <?=$order->payment_name?></td>
            <td><?=date('Y-m-d H:i:s',$order->create_time)?></td>
            <td><?=\frontend\models\Order::$statusOption[$order->status]?></td>
            <td><?= \yii\helpers\Html::a('发货',['order/update','id'=>$order->id],['class'=>'btn btn-warning'])?>  <?= \yii\helpers\Html::a('删除',['article/delete','id'=>$order->id],['class'=>'btn btn-danger'])?></td>
        </tr>
    <?php endforeach;?>
<?php }?>

</table>
<?php
echo \yii\widgets\LinkPager::widget([ 'pagination'=>$page,
    'nextPageLabel'=>'下一页', 'prevPageLabel'=>'上一页'

]);