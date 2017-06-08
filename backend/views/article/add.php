<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 17:30
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Article::$sexOptions);
echo $form->field($model,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($data,'id','name'),['prompt' => '请选择文章分类']);
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'intro')->textarea();
echo \yii\helpers\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
