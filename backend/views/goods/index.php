<?= \yii\helpers\Html::a('添加商品',['goods/add'],['class'=>'btn btn-info'])?>
<?php $form = \yii\bootstrap\ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'cateadd-form',
    'options' => ['class' => 'form-inline'],
]); ?>
<?= $form->field($searchModel, 'name',[
    'options'=>['class'=>''],
    'inputOptions' => ['placeholder' => '商品搜索','class' => 'input-sm form-control'],
])->label(false) ?>
<?= $form->field($searchModel, 'sn',[
    'options'=>['class'=>''],
    'inputOptions' => ['placeholder' => '编号搜索','class' => 'input-sm form-control'],
])->label(false) ?>
<span class="input-group-btn">
    <?= \yii\helpers\Html::submitButton('点击搜索', ['class' => 'btn btn-primary']) ?>
</span>
<?php \yii\bootstrap\ActiveForm::end(); ?>

<?php
use yii\grid\GridView;
echo GridView::widget([
    'dataProvider' => $dataProvider,
    //每列都有搜索框 控制器传过来$searchModel = new ArticleSearch();
    //'filterModel' => $searchModel,
    'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
    'pager'=>[
        //'options'=>['class'=>'hidden']//关闭自带分页
        'firstPageLabel'=>"First",
        'prevPageLabel'=>'Prev',
        'nextPageLabel'=>'Next',
        'lastPageLabel'=>'Last',
    ],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],//序列号从1开始
        // 数据提供者中所含数据所定义的简单的列
        // 使用的是模型的列的数据
        ['label'=>'商品编号','value' => 'sn'],
        'name',
        ['label'=>'商品类别',  /*'attribute' => 'cid',产生一个a标签,点击可排序*/  'value' => 'category.name' ],
        ['label'=>'发布日期','format' => ['date', 'php:Y-m-d'],'value' => 'create_time'],
        ['label'=>'商品价格','value' => 'shop_price'],

        // 更复杂的列数据
        ['label'=>'封面图','format'=>'raw','value'=>function($m){
            return \yii\helpers\Html::img(Yii::getAlias('@web').$m->logo,['class' => 'img-circle','width' => 30]);
        }],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{delete} {update} {content}{gilary}',//只需要展示删除和更新
            /*'headerOptions' => ['width' => '80'],*/
            'buttons' => [
                'delete' => function($url, $model, $key){
                    return \yii\helpers\Html::a('<i class="glyphicon glyphicon-trash"></i> 删除',
                        ['delete', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs',
                            'data' => ['confirm' => '你确定要删除该商品吗？',]
                        ]);
                },
                'update' => function($url, $model, $key){
                    return \yii\helpers\Html::a('<i class="fa fa-file"></i> 更新',
                        ['edit', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs']);
                },
                'content' => function($url, $model, $key){
                    return \yii\helpers\Html::a('<i class="fa fa-file"></i> 详情',
                        ['content', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs']);
                },
                'gilary' => function($url, $model, $key){
                    return \yii\helpers\Html::a('<i class="glyphicon glyphicon-picture"></i> 相册',
                        ['gilary', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs']);
                },
            ],
    ],
    ],
]);