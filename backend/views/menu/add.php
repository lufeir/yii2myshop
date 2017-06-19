<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/18
 * Time: 11:34
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'label');
echo $form->field($model,'sort');
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getParent(),['prompt' => '请选择上级菜单','']);
echo $form->field($model,'url');
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();