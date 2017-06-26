<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;


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

    public function actionLogin(){
        $model = new LoginForm();             //②
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            $user=Member::findOne(['username'=>$model->username]);
            $user->last_login_time=time();
            $user->last_login_ip= ip2long(\Yii::$app->request->userIP);
            $user->save(false);
            return $this->redirect(['goods/index']);          //④
        }
        return $this->render('login', ['model' =>$model]);
    }
   public function actionLogout(){
       \Yii::$app->user->logout();
       return $this->redirect(['user/login']);
   }
   public function actionTest(){
       $tel=\Yii::$app->request->post('tel');
       if(!preg_match('/^1[34578]\d{9}$/',$tel)){
           echo '电话号码不正确';
           exit;
       }
     $code=rand(10000,99999);
       $config = [
           'app_key'    => '24479134',
           'app_secret' => '1a5472e8eb7137fa8a193eb1fcc9e7b1',
           // 'sandbox'    => true,  // 是否为沙箱环境，默认false
       ];

// 使用方法一
       $client = new Client(new App($config));
       $req    = new AlibabaAliqinFcSmsNumSend;

       $req->setRecNum($tel)
           ->setSmsParam([
               'code' => $code
           ])
           ->setSmsFreeSignName('李政宇的个人网站')
           ->setSmsTemplateCode('SMS_71480185');

       $result = $client->execute($req);
       if($result){
           //保存当前验证码 session  mysql  redis  不能保存到cookie
//            \Yii::$app->session->set('code',$code);
//            \Yii::$app->session->set('tel_'.$tel,$code);
           \Yii::$app->cache->set('tel_'.$tel,$code,5*60);
           echo 'success'.$code;
       }else{
           echo '发送失败';
       }
   }
   public function actionMali(){
       Yii::$app->mailer->compose()
           ->setFrom('as779802422@163.com')
           ->setTo('779802422@qq.com')
           ->setSubject('Message subject')
           ->setTextBody('Plain text content')
           ->setHtmlBody('<b>HTML content</b>')
           ->send();
   }

}
