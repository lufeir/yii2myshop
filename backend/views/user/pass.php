<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/14
 * Time: 14:46
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'oldpassword')->passwordInput();
echo $form->field($model,'newpassword')->passwordInput();
echo $form->field($model,'repassword')->passwordInput();
echo \yii\helpers\Html::submitButton('确认修改',['class'=>'btn btn-primary']);
\yii\bootstrap\ActiveForm::end();