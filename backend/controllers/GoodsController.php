<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/12
 * Time: 11:24
 */
namespace backend\controllers;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGilary;
use backend\models\GoodsIntro;
use backend\models\search\GoodsSearch;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class GoodsController extends Controller{
    public function actionAdd(){
        $model=new Goods();
        $brand=Brand::find()->all();
        $content=new GoodsIntro();
        $request=new Request();
        $time=date('Ymd',time());
        $days=new GoodsDayCount();
        $daycount=GoodsDayCount::findOne(['day'=>$time]);
        if($request->isPost){
            $model->load($request->post());
            $content->load($request->post());
            if($model->validate() && $content->validate()){
                if(!$daycount){
                    $days->day=$time;
                    $days->count=1;
                    $days->save();
                    $model->sn=date('Ymd',time()).'0001';
                }else{
                    $daycount->count+=1;
                    $daycount->save();
                    $model->sn=$time.str_pad($daycount->count,4,0,STR_PAD_LEFT);
                }
                $model->create_time=time();
                $model->save();
                $content->goods_id=$model->id;
                $content->save();
                \Yii::$app->session->setFlash('success','品牌添加成功');
            }
          return $this->redirect(['goods/index']);
        }
        $GoodsCategory=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>'顶级分类']],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'brand'=>$brand,'GoodsCategory'=>$GoodsCategory,'content'=>$content]);
    }
    public function actionIndex(){
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionEdit($id){
        $model=Goods::findOne(['id'=>$id]);
        $brand=Brand::find()->all();
        $content=GoodsIntro::findOne(['goods_id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $content->load($request->post());
            if($model->validate() && $content->validate()){
                $model->save();
                $content->save();
                \Yii::$app->session->setFlash('success','品牌修改成功');
            }
            return $this->redirect(['goods/index']);
        }
        $GoodsCategory=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>'顶级分类']],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'brand'=>$brand,'GoodsCategory'=>$GoodsCategory,'content'=>$content]);

    }
    public function actionContent($id){
        $model=Goods::findOne(['id'=>$id]);
        $content=GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('content',['model'=>$model,'content'=>$content]);
    }
    public function actionDelete($id){
        $model=Goods::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        return $this->redirect(['goods/index']);
    }
    public function actionGilary($id){
        $goods=Goods::findOne(['id'=>$id]);
        if(!$goods){
            throw new NotFoundHttpException('商品不存在');
        }
        return $this->render('gilary',['goods'=>$goods]);
    }
    public function actionDelGilary(){
        $id = \Yii::$app->request->post('id');
        $model = GoodsGilary::findOne(['id'=>$id]);
        if($model && $model->delete()){
            return 'success';
        }else{
            return 'fail';
        }

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
            's-upload1' => [
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
                    $model= new GoodsGilary();
                    $model->goods_id=\Yii::$app->request->post('goods_id');
                    $model->path=$action->getWebUrl();
                    $model->save();
                    $action->output['fileUrl'] = $model->path;
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
}