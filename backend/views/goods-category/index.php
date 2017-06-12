<?= \yii\helpers\Html::a('添加商品分类',['goods-category/add'],['class'=>'btn btn-info'])?>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>分类名称</th>
            <th>简介</th>
            <th>层级</th>
            <td>操作</td>
        </tr>
        <?php foreach ($models as $model):?>

                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->name?></td>
                    <td><?=$model->intro?></td>
                    <td><?=$model->depth?></td>
                    <td><?= \yii\helpers\Html::a('修改',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-warning'])?> &emsp;&emsp;<?= \yii\helpers\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-danger'])?></td>

                </tr>
        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\linkPager::widget([ 'pagination'=>$page,
    'nextPageLabel'=>'下一页', 'prevPageLabel'=>'上一页'

]);