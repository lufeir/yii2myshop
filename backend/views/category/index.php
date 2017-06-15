<?= \yii\helpers\Html::a('添加分类',['category/add'],['class'=>'btn btn-info'])?>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>分类名称</th>
            <th>简介</th>
            <th>类型</th>
            <td>操作</td>
        </tr>
        <?php foreach ($models as $model):?>
            <?php if($model->status>0){?>
                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->name?></td>
                    <td><?=$model->intro?></td>
                    <td><?=$model->is_help?'帮助文档':'普通文章'?></td>
                    <td><?= \yii\helpers\Html::a('修改',['category/edit','id'=>$model->id],['class'=>'btn btn-warning'])?> &emsp;&emsp;<?= \yii\helpers\Html::a('删除',['category/delete','id'=>$model->id],['class'=>'btn btn-danger'])?></td>

                </tr>
            <?php } ?>
        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\LinkPager::widget([ 'pagination'=>$page,
    'nextPageLabel'=>'下一页', 'prevPageLabel'=>'上一页'

]);