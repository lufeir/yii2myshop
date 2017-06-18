<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/16
 * Time: 15:14
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo $form->field($model,'permissions')->checkboxList(\backend\models\RoleForm::getPermissionOption());
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();