<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
{
   public function actionAdd(){
       $model=new GoodsCategory();
       $request=new Request();
       if($model==null){
           throw new NotFoundHttpException('分类不存在');
       }
       if($request->isPost){
           $model->load($request->post());
           if($model->validate()){
               //添加非一级分类
               if($model->parent_id){
                   //获取上一级
                   $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                   $model->prependTo($parent);
               }else{
                   $model->makeRoot();
               }
           }
           \Yii::$app->session->setFlash('success','添加分类成功');
           $this->redirect(['goods-category/index']);

       }
       $categories=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
//     var_dump($categories);exit();
       return $this->render('add',['model'=>$model,'categories'=>$categories]);
   }
  public function actionIndex(){
      $query=GoodsCategory::find();//
      $total=$query->count();//统计个数
      //调用分页工具
      $page=new Pagination(['defaultPageSize'=>2,
          'totalCount'=>$total
      ]);
      $models=$query->offset($page->offset)->limit($page->limit)->all();//获取每页数据
      return $this->render('index',['models'=>$models,'page'=>$page]);
  }
  public function actionEdit($id){
      $model=GoodsCategory::findOne(['id'=>$id]);
      $request=new Request();
      if($model==null){
          throw new NotFoundHttpException('分类不存在');
      }
      if($request->isPost){
          $model->load($request->post());
          if($model->validate()){
              //修改非一级分类
              if($model->parent_id){
                  //获取上一级
                  $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                  $model->prependTo($parent);
              }else{
                  if($model->parent_id == $model->getOldAttribute('parent_id')){
                      $model->save();
                  }else{
                      $model->makeRoot();
                  }
              }
          }
          \Yii::$app->session->setFlash('success','添加分类成功');
          $this->redirect(['goods-category/index']);

      }
      //
      $categories=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
//       var_dump($categories);exit();
      return $this->render('add',['model'=>$model,'categories'=>$categories]);
  }
}
