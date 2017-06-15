<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/14
 * Time: 15:23
 */
namespace backend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $code;
    public $rememberMe;
    private $_user = false;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            //添加自定义验证方法
            ['username','validateUsername'],
            ['rememberMe', 'boolean'],
            ['code','captcha','captchaAction'=>'user/captcha'],
        ];
    }
    public function attributeLabels()
    {
       return [
           'username'=>'用户名',
           'password'=>'密码',
           'code'=>'验证码',
           'rememberMe'=>'记住我',
       ];
    }
    public function login()
    {
        if ($this->validate()) {
            if($this->rememberMe)
            {
                return \Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            }

        }
        return false;
    }
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username); //②
        }

        return $this->_user;
    }
    public function validateUsername(){
        $user=User::findOne(['username'=>$this->username]);
        if($user){
            if(\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                \Yii::$app->user->login($user);
            }else{
                $this->addError('password','用户名或密码不正确');
            }
        }else{
           $this->addError('username','用户名不存在');
        }
    }
}