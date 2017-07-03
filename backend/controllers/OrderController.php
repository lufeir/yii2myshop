<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/26
 * Time: 10:55
 */
namespace backend\controllers;
use frontend\models\Order;
use yii\data\Pagination;
use yii\web\Controller;

class OrderController extends Controller{
    public function actionIndex(){
        $query=Order::find();
        $total=$query->count();
        $page=new Pagination(['defaultPageSize'=>2,
            'totalCount'=>$total
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
}