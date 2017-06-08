<?= \yii\helpers\Html::a('添加文章',['article/add'],['class'=>'btn btn-info'])?>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>文章名称</th>
            <th>简介</th>
            <th>分类</th>
            <th>创建时间</th>
            <td>操作</td>
        </tr>
        <?php foreach ($models as $model):?>
            <?php if($model->status>0){?>
                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->name?></td>
                    <td><?= substr($model->intro,0,30)?></td>
                    <td><?=$model->category->name?></td>
                    <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
                    <td><?= \yii\helpers\Html::a('修改',['article/edit','id'=>$model->id],['class'=>'btn btn-warning'])?> &emsp;&emsp;<?= \yii\helpers\Html::a('删除',['article/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>&emsp;<?= \yii\helpers\Html::a('查看详情',['article/content','id'=>$model->id],['class'=>'btn btn-info'])?></td>

                </tr>
            <?php } ?>
        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\linkPager::widget([ 'pagination'=>$page,
    'nextPageLabel'=>'下一页', 'prevPageLabel'=>'上一页'

]);