<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/26
 * Time: 18:23
 */
namespace console\controllers;
 use backend\models\Goods;
 use frontend\models\Order;
 use yii\console\Controller;
 class  TaskController extends Controller{
     public function actionClean(){
         set_time_limit(0);//不限制脚本执行时间
         while(1){
             $models=Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->all();
             if($models==null){
                 echo "No Have THIS id \n";
             }else{
                 foreach ($models as $model){
                     $model->status=0;
                     $model->save();
                     foreach ($model->ogoods as $goods){
                         Goods::updateAllCounters(['stock'=>$goods->amount],['id'=>$goods->goods_id]);
                     }
                     echo "ID".$model->id." has been clean...\n";
                 }
             }

             sleep(1);
         }

     }
 }