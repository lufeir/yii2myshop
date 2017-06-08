<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 16:46
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏']);
echo $form->field($model,'is_help',['inline'=>true])->radioList([1=>'帮助文档',0=>'普通文章']);
echo $form->field($model,'sort')->textInput();

echo $form->field($model,'intro')->textarea();
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();