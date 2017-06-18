
<?= \yii\helpers\Html::a('添加权限',['rbac/add-permission'],['class'=>'btn btn-info'])?>
<table class="table table-responsive table-bordered">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
        <td><?= $model->name?></td>
        <td><?= $model->description?></td>
        <td><?= \yii\helpers\Html::a('修改',['rbac/edit-permission','name'=>$model->name],['class'=>'btn btn-warning btn-xs'])?> &emsp;&emsp;<?= \yii\helpers\Html::a('删除',['rbac/del-permission','name'=>$model->name],['class'=>'btn btn-danger btn-xs'])?></td>
        </tr>
    <?php endforeach;?>
</table>