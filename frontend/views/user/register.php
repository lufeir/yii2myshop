

<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
             $form=\yii\widgets\ActiveForm::begin(
                 ['fieldConfig'=>[
                     'options'=>[
                         'tag'=>'li',
                     ],
                     'errorOptions'=>[
                         'tag'=>'p'
                     ]
                 ]]
             );
             echo '<ul>';
             echo $form->field($model,'username')->textInput(['class'=>'txt']);
             echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
             echo $form->field($model,'rePassword')->passwordInput(['class'=>'txt']);
             echo $form->field($model,'email')->textInput(['class'=>'txt']);
             echo $form->field($model,'tel')->textInput(['class'=>'txt']);
             echo $form->field($model,'code',['options'=>['class'=>'checkcode']])->widget(\yii\captcha\Captcha::className(),['template'=>'{input}{image}']);
             echo '<li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
                   </li>';
            echo '<li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn">
                    </li>';
             echo '</ul>';
             \yii\widgets\ActiveForm::end();
            ?>

        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
>