<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/14
 * Time: 14:03
 */
namespace backend\models;
use yii\base\Model;

class PasswordForm extends Model{
    public $oldpassword;//原密码
    public $newpassword;//新密码
    public $repassword;//确认密码
    public function rules()
    {
        return[
            ['oldpassword','required'],
            ['oldpassword','validatePassword'],
            ['newpassword','required'],
            ['repassword','compare','compareAttribute'=>'newpassword','message'=>'两次密码必须一致'],
        ];
    }
    public function attributeLabels()
    {
        return[
            'oldpassword'=>'原密码',
            'newpassword'=>'新密码',
            'repassword'=>'确认密码'
        ];
    }
    public function validatePassword(){
        $password_hash=\Yii::$app->user->identity->password_hash;
        $password=$this->oldpassword;
        if(!\Yii::$app->security->validatePassword($password,$password_hash)){
            $this->addError('oldpassword','旧密码不正确');
        }

    }
}