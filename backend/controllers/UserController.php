<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/14
 * Time: 10:30
 */
namespace backend\controllers;
use backend\filetr\RbacFilter;
use backend\models\LoginForm;
use backend\models\PasswordForm;
use backend\models\User;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;

class UserController extends Controller{
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','index','edit'],

            ]
        ];
    }
    public function actionAdd(){
        $model=new User();
       $model->setScenario('add');
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                $model->upRole($model->id);
                \Yii::$app->session->setFlash('success','添加成功');
                $this->redirect(['user/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){
        $query=User::find();
        $total=$query->count();
        $page=new Pagination(['defaultPageSize'=>2,
            'totalCount'=>$total
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
    public function actionEdit($id){
        $model=User::findOne(['id'=>$id]);
       $model->setScenario('edit');
        $request=new Request();
        $model->loadData($id);
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->updated_at=time();
                $model->save();
                $model->edRole($id);
                \Yii::$app->session->setFlash('success','修改成功');
                $this->redirect(['user/index']);
            }
        }
        return $this->render('add',['model'=>$model]);

    }
    public function actionUppasword(){
        $model=new PasswordForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $user=\Yii::$app->user->identity;
                $user->password_hash=$model->newpassword;
                if($user->save(false)){
                    \Yii::$app->session->setFlash('success','密码修改成功');
                    return $this->redirect(['user/index']);
                }else{
                    var_dump($user->getErrors());exit;
                }
            }
        }
        return $this->render('pass',['model'=>$model]);
    }
    public function actionLogin(){
        //判断是不是游客。

        $model = new LoginForm();             //②
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {      //③
            return $this->redirect(['user/index']);          //④
        }
        return $this->render('login', ['model' =>$model]);
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['user/login']);
    }


    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 5,//间距
                'height'=>40,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                      //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
            ],

        ];
    }

}