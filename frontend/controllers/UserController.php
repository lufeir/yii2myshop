<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;

class UserController extends \yii\web\Controller
{     public $layout = 'login';
    public function actionRegister(){
        $model=new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save(false);
            \Yii::$app->session->setFlash('success','注册账号成功');
            return $this->redirect(['user/login']);
        }
        return $this->render('register',['model'=>$model]);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionLogin(){
        $model = new LoginForm();             //②
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            $user=Member::findOne(['username'=>$model->username]);
            $user->last_login_time=time();
            $user->last_login_ip= ip2long(\Yii::$app->request->userIP);
            $user->save(false);
            return $this->redirect(['user/index']);          //④
        }
        return $this->render('login', ['model' =>$model]);
    }
   public function actionLogout(){
       \Yii::$app->user->logout();
       return $this->redirect(['user/login']);
   }
}
