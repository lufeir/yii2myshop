<?= \yii\helpers\Html::a('添加角色',['rbac/add-role'],['class'=>'btn btn-info'])?>
<table class="table table-responsive table-bordered">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>权限</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?= $model->name?></td>
            <td><?= $model->description?></td>
            <td><?php foreach (\Yii::$app->authManager->getPermissionsByRole($model->name) as $permission){
                        echo $permission->description;
                        echo ','.'&ensp;';
                }?>
            </td>
            <td><?= \yii\helpers\Html::a('修改',['rbac/edit-role','name'=>$model->name],['class'=>'btn btn-warning btn-xs'])?> &emsp;&emsp;<?= \yii\helpers\Html::a('删除',['rbac/del-role','name'=>$model->name],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>