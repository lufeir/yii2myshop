<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/18
 * Time: 11:23
 */
namespace backend\controllers;
use backend\models\Menu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MenuController extends Controller{
    public function actionAdd(){
        $model=new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->valiadateM()){
                $model->save();
                \Yii::$app->session->setFlash('success','菜单添加成功');
                return $this->redirect(['menu/index']);
            }

        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){
      $models=Menu::find()->all();
      return $this->render('index',['models'=>$models]);
    }
    public function actionEdit($id){
        $model=Menu::findOne(['id'=>$id]);
        if($model==null){
            throw  new NotFoundHttpException('该菜单不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
                if($model->valiadateE($id)){
                    $model->save();
                    \Yii::$app->session->setFlash('success','菜单添加成功');
                    return $this->redirect(['menu/index']);
                }
        }

        return $this->render('add',['model'=>$model]);

    }
    public function actionDelete($id){
        $model=Menu::findOne(['id'=>$id]);
        if($model==null){
            throw  new NotFoundHttpException('该菜单不存在');
        }
        $model->delete();
        return $this->redirect(['menu/index']);
    }
}