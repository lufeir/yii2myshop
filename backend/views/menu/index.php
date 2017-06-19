<table class=" table table-bordered table-responsive">
    <tr>
        <th>菜单名称</th>
        <th>菜单路由</th>
        <th>子级菜单</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->label?></td>
            <td> <?=$model->url?>
            <td>  <?php foreach ($model->children as $child){
                echo $child->label;
                echo ',';
            }?></td>
            <td>
                <?= \yii\helpers\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?> &ensp;<?= \yii\helpers\Html::a('删除',['menu/delete','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>