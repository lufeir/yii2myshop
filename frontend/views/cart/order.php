<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('@web/style/fillin.css');
$this->registerJsFile('@web/js/cart2.js',['depends'=>\yii\web\JqueryAsset::className()]);
?>
<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
                <?php  foreach ($address as $addres ):   ?>
                <input type="radio" value="<?=$addres->id?>" name="address_id"/><?=$addres->user_name?>  <?= $addres->tel?>  <?=\frontend\models\Locations::getArea($addres->province)?> <?=\frontend\models\Locations::getArea($addres->city)?> <?=\frontend\models\Locations::getArea($addres->district)?> <?=$addres->content?> </p>
               <?php endforeach;?>
            </div>


        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="cur" id="payment_id">
                        <td>
                            <input type="radio" name="delivery" checked="checked" value="1" />普通快递送货上门

                        </td>
                         <td>10.00</td>
                        <td>每张订单不满499.00元,运费15.00元, 订单4...</td>
                    </tr>
                    <tr>

                        <td><input type="radio" name="delivery"value="2" />特快专递</td>
                        <td>40.00</td>
                        <td>每张订单不满499.00元,运费40.00元, 订单4...</td>
                    </tr>
                    <tr>

                        <td><input type="radio" name="delivery" value="3"/>加急快递送货上门</td>
                        <td>40.00</td>
                        <td>每张订单不满499.00元,运费40.00元, 订单4...</td>
                    </tr>
                    <tr>

                        <td><input type="radio" name="delivery" value="4"/>平邮</td>
                         <td>10.00</td>
                        <td>每张订单不满499.00元,运费15.00元, 订单4...</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>


            <div class="pay_select">
                <table>
                    <tr class="cur">
                        <td class="col1"><input type="radio" name="pay" value="1" />货到付款</td>
                        <td class="col2">送货上门后再收款，支持现金、POS机刷卡、支票支付</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" value="2"/>在线支付</td>
                        <td class="col2">即时到帐，支持绝大数银行借记卡及部分银行信用卡</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" value="3"/>上门自提</td>
                        <td class="col2">自提时付款，支持现金、POS刷卡、支票支付</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" value="4"/>邮局汇款</td>
                        <td class="col2">通过快钱平台收款 汇款后1-3个工作日到账</td>
                    </tr>
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <div class="receipt none">
            <h3>发票信息 </h3>


            <div class="receipt_select ">
                <form action="">
                    <ul>
                        <li>
                            <label for="">发票抬头：</label>
                            <input type="radio" name="type" checked="checked" class="personal" />个人
                            <input type="radio" name="type" class="company"/>单位
                            <input type="text" class="txt company_input" disabled="disabled" />
                        </li>
                        <li>
                            <label for="">发票内容：</label>
                            <input type="radio" name="content" checked="checked" />明细
                            <input type="radio" name="content" />办公用品
                            <input type="radio" name="content" />体育休闲
                            <input type="radio" name="content" />耗材
                        </li>
                    </ul>
                </form>

            </div>
        </div>
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php $total=null;?>
                <?php foreach ($models as $model):?>
                <tr>
                    <td class="col1"><a href=""><?= \yii\helpers\Html::img('http://admin.yii2shop.com'.$model['logo'])?></a>  <strong><a href="http://www.yii2shop.com/address/content.html?id=<?=$model['id']?>">【1111购物狂欢节】<?=$model['name']?></a></strong></td>
                    <td class="col3">￥<?=$model['shop_price']?></td>
                    <td class="col4"> <?=$model['amount']?></td>
                    <td class="col5"><span>￥<?=($model['shop_price']*$model['amount'])?></span></td>
                </tr>
                    <?php $total+=($model['shop_price']*$model['amount']);?>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span ><?=count($models)?> 件商品，总商品金额：</span>
                                ￥<em id="total_price"><?php echo $total;?></em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                ￥<em>5076.00</em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:;"><span>提交订单</span></a>
        <p>应付总额：<strong>￥</strong><strong>5076.00</strong><strong>元</strong></p>

    </div>
</div>
<!-- 主体部分 end -->

<?php
$total_price=$total-240;
$token = Yii::$app->request->csrfToken;
$url=\yii\helpers\Url::to(['cart/order']);
 $this->registerJs(new \yii\web\JsExpression(
         <<<JS

    $(".delivery_select input").click(function() {
       price=$(this).closest("tr").find("td:eq(1)").text();
      
     $("tfoot li:eq(2)").find("em").text(price);
    });
     var yunfei=$("tfoot li:eq(2)").find("em").text();
   
    var end_price="$total_price"-Number(yunfei);
    $("tfoot li:eq(3)").find("em").text(end_price);
    $(".fillin_ft strong:eq(1)").text(end_price);
    $(".fillin_ft a").click(function() {
        var address=$(".address_info input:checked").val();
         var delivery_id=$(".delivery input:checked").val();
         var price=$(".fillin_ft strong:eq(1)").text();
         var payment_id=$(".pay_select input:checked").val();
         var data={address_id:address,delivery_id:delivery_id,price:price,payment_id:payment_id,"_csrf-frontend":"$token"};
         $.post("$url",data,function() {
           window.location="http://www.yii2shop.com/cart/order-true.html";
         });
       
      
    });
   

   
 
    
JS

 ));
