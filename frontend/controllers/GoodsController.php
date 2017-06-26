<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/21
 * Time: 14:20
 */
namespace frontend\controllers;
use backend\models\GoodsCategory;
use yii\web\Controller;

class GoodsController extends Controller{
    public $layout='index';
    public function actionIndex(){
        $categorties=GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index',['categories'=>$categorties]);
    }

}