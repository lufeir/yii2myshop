<?= \yii\helpers\Html::a('添加品牌',['brand/add'],['class'=>'btn btn-info'])?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>品牌名称</th>
        <th>简介</th>
        <th>品牌图片</th>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
        <?php if($model->status>0){?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->intro?></td>
            <td><?=\yii\helpers\Html::img($model->logo,['width'=>80])?></td>
            <td><?= \yii\helpers\Html::a('修改',['brand/edit','id'=>$model->id],['class'=>'btn btn-warning'])?> &emsp;&emsp;<?= \yii\helpers\Html::a('删除',['brand/delete','id'=>$model->id],['class'=>'btn btn-danger'])?></td>

        </tr>
    <?php } ?>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([ 'pagination'=>$page,
    'nextPageLabel'=>'下一页', 'prevPageLabel'=>'上一页'

]);