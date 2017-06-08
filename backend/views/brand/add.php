<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 15:26
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏']);
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'imgFile')->fileInput();
if($model->logo){
    echo \yii\helpers\Html::img($model->logo,['width'=>80]);
}
echo $form->field($model,'intro')->textarea();
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();