<div class="category fl"> <!-- 非首页，需要添加cat1类 -->
    <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
        <h2>全部商品分类</h2>
        <em></em>
    </div>
    <div class="cat_bd">
    </div>
    <?php
    foreach ($goods_categorys as $goods_category):?>
        <div class="cat">
            <h3><?php echo \yii\helpers\Html::a( $goods_category->name,['address/list','id'=>$goods_category->id])?><b></b></h3>
            <div class="cat_detail">

                <?php
                $goods_tos=\backend\models\GoodsCategory::find()->where(['parent_id'=>$goods_category->id])->all();
                foreach ($goods_tos as $goods_to):
                    ?>
                    <dl>

                        <dt><?=\yii\helpers\Html::a($goods_to->name,['address/list','id'=>$goods_to->id])?></dt>
                        <?php
                        $goods_ths=\backend\models\GoodsCategory::find()->where(['parent_id'=>$goods_to->id])->all();
                        foreach ($goods_ths as $goods_th):
                            ?>
                            <dd>
                                <?=\yii\helpers\Html::a($goods_th->name,['address/list','id'=>$goods_th->id])?>
                            </dd>
                        <?php endforeach;?>
                    </dl>
                <?php endforeach;?>

            </div>
        </div>
    <?php endforeach; ?>
</div>