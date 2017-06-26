<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/21
 * Time: 9:47
 */
namespace frontend\controllers;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsIntro;
use frontend\models\Area;
use frontend\models\Locations;
use yii\data\Pagination;
use yii\web\Controller;

class AddressController extends Controller{
    public $layout = 'address';
    public function actionIndex(){
       $model=new Area();
       $areas=Area::findAll(['member_id'=>\Yii::$app->user->id]);
       if($model->load(\Yii::$app->request->post()) && $model->validate()){
           if($model->is_mo){
               foreach ($areas as $area){
                   $area->is_mo=0;
                   $area->save();
               }
           }
           $model->member_id=\Yii::$app->user->id;
           $model->save();
           return $this->redirect(['address/index']);
       }
       return $this->render('address',['model'=>$model,'areas'=>$areas]);
    }
    public function actionEdit($id){
        $model=Area::findOne(['id'=>$id]);
        $areas=Area::findAll(['member_id'=>\Yii::$app->user->id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->is_mo){
                foreach ($areas as $area){
                    $area->is_mo=0;
                    $area->save();
                }
            }
            $model->save();
            return $this->redirect(['address/index']);
        }
        return $this->render('address',['model'=>$model,'areas'=>$areas]);
    }
    public function actionUpd($id){
        $model=Area::findOne(['id'=>$id]);
        $model->is_mo=1;
        $model->save();
        $models=Area::find()->where('id!='.$id)->all();
         foreach ($models as $model1){
             $model1->is_mo=0;
             $model1->save();
         }

        return $this->redirect(['address/index']);

    }
    public function actionDel($id){
        $model=Area::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['address/index']);
    }
    public function actionList($id){
        $category=GoodsCategory::findOne(['id'=>$id]);
        if($category->depth<2){
            $categories=GoodsCategory::find()->where(['and' , 'lft > '.$category->lft , 'rgt < '.$category->rgt,['=','tree',$category->tree]])->all();
             if($categories){
                 foreach ($categories as $category){
                     $newcategory[]=$category->id;
                 }
                 $query=Goods::find()->where(['in','goods_category_id',$newcategory]);
             }else{
                 $query=Goods::find()->where(['goods_category_id'=>$id]);
             }
        }else{
            $query=Goods::find()->where(['goods_category_id'=>$id]);
        }
        $total=$query->count();
        $page=new Pagination(['defaultPageSize'=>4,
            'totalCount'=>$total
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();

        return $this->render('list',['models'=>$models,'page'=>$page]);
    }
    public function actionContent($id){
        $content=GoodsIntro::findOne(['goods_id'=>$id]);
        $goods=Goods::findOne(['id'=>$id]);
        return $this->render('content',['goods'=>$goods,'content'=>$content]);
    }

    public function actions()
    {
        $actions=parent::actions();
        $actions['get-region']=[
            'class'=>\chenkby\region\RegionAction::className(),
            'model'=>Locations::className()
        ];
        return $actions;
    }
}