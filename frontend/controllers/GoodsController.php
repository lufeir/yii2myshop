<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/21
 * Time: 14:20
 */
namespace frontend\controllers;
use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\compoents\SphinxClient;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class GoodsController extends Controller{
    public $layout='index';
    public function actionIndex(){
        $categorties=GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index',['categories'=>$categorties]);
    }
    public function actionList(){
        $this->layout="address";
        $query=Goods::find();
        if($keyword=\Yii::$app->request->get('keyword')){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');//shopstore_search
            if(!isset($res['matches'])){
//                throw new NotFoundHttpException('没有找到xxx商品');
                $query->where(['id'=>0]);
            }else{

                //获取商品id
                //var_dump($res);exit;
                $ids = ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }
        }
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>5
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        if($keyword=\Yii::$app->request->get('keyword')){
            $keywords = array_keys($res['words']);
            $options = array(
                'before_match' => '<span style="color:red;">',
                'after_match' => '</span>',
                'chunk_separator' => '...',
                'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
            );
            foreach ($models as $index => $item) {
                $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
                $models[$index]->name = $name[0];
//            var_dump($name);
            }
        }

        return $this->render('list',['models'=>$models,'page'=>$pager]);

    }

}