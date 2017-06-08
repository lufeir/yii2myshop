<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 15:24
 */
namespace backend\controllers;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends Controller{
    public function actionAdd(){
        $model=new Brand();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $filename='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$filename,false);
                    //将路径保存到数据库
                    $model->logo=$filename;
                }
                $model->save();
                \Yii::$app->session->setFlash('success','品牌添加成功');

                return $this->redirect(['brand/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){
        $query=Brand::find()->where(['status'=>1])->orderBy('sort');
        $total=$query->count();
        $page=new Pagination(['defaultPageSize'=>2,
            'totalCount'=>$total
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
    public function actionEdit($id){
        $model=Brand::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $filename='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$filename,false);
                    //将路径保存到数据库
                    $model->logo=$filename;
                }
                $model->save();
                \Yii::$app->session->setFlash('success','品牌添加成功');

                return $this->redirect(['brand/index']);
            }
        }
        return $this->render('add',['model'=>$model]);

    }
    public function actionDelete($id){
        $model=Brand::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['brand/index']);

    }
}