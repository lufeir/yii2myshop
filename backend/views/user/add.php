<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/14
 * Time: 10:31
 */
use yii\web\JsExpression;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
if(!$model->password_hash){
    echo $form->field($model,'password_hash')->passwordInput();
    echo $form->field($model,'password2')->passwordInput();
}
echo $form->field($model,'email')->textInput();
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'未激活']);
echo $form->field($model,'roles',['inline'=>true])->checkboxList(\backend\models\User::getRoles());
echo $form->field($model,'logo')->hiddenInput(['id'=>'logo_id']);
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        $('#img_logo').attr('src',data.fileUrl).show();
        $('#logo_id').val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\helpers\Html::img(Yii::getAlias('@web').$model->logo,['id'=>'logo','width'=>50]);
}else {
    echo \yii\helpers\Html::img('', ['style' => 'display:none', 'id' => 'img_logo', 'width' => 50]);
}
echo '<br />';
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();