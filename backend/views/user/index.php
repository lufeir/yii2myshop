<?= \yii\helpers\Html::a('添加管理员',['user/add'],['class'=>'btn btn-info'])?>
<?= \yii\helpers\Html::a('重置密码',['user/uppasword'],['class'=>'btn btn-primary'])?>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>创建时间</th>
            <th>logo</th>
            <td>操作</td>
        </tr>
        <?php foreach ($models as $model):?>

                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->username?></td>
                    <td><?=$model->email?></td>
                    <td><?=date('Y-m-d H:i:s',$model->created_at)?></td>
                    <td><?=\yii\helpers\Html::img(Yii::getAlias('@web').$model->logo,['width'=>60])?></td>
                    <td><?php
                        if(\Yii::$app->user->can('user/edit'))
                        {
                            echo \yii\helpers\Html::a('修改',['user/edit','id'=>$model->id],['class'=>'btn btn-warning']);
                        }
                        if(\Yii::$app->user->can('user/edit')){
                            echo \yii\helpers\Html::a('删除',['user/delete','id'=>$model->id],['class'=>'btn btn-danger']);
                        }
                        ?></td>

                </tr>

        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\LinkPager::widget([ 'pagination'=>$page,
    'nextPageLabel'=>'下一页', 'prevPageLabel'=>'上一页'

]);