<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 17:28
 */
namespace backend\controllers;
use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
//文章控制器
class ArticleController extends Controller{
    //添加文章的操作
    public function actionAdd(){
        $model=new Article();//实例化article
        $model2=new ArticleDetail();//实例化文章详情类
        $data=ArticleCategory::find()->all();//找到所有的分类数据
        $request=new Request();
        if($request->isPost){//判断请求参数
            $model->load($request->post());
            $model2->load($request->post());
            if($model->validate() && $model2->validate()){
                $model->create_time=time();
                $model->save();
                $model2->article_id=$model->id;
                $model2->save();
                \Yii::$app->session->setFlash('success','文章添加成功');
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'data'=>$data,'model2'=>$model2]);
    }
    public function actionIndex(){
        $query=Article::find()->where(['status'=>1])->orderBy('sort');
        $total=$query->count();
        $page=new Pagination(['defaultPageSize'=>2,
            'totalCount'=>$total
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }
    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $model2=ArticleDetail::findOne(['article_id'=>$id]);
        $data=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model2->load($request->post());
            if($model->validate()){
                $model->save();
                $model2->save();
                \Yii::$app->session->setFlash('success','文章修改成功');
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'data'=>$data,'model2'=>$model2]);

    }
    public function actionDelete($id){
        $model=Article::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['article/index']);
    }
    public function actionContent($id){
        $content=ArticleDetail::findOne(['article_id'=>$id]);
        $model=Article::findOne(['id'=>$id]);
        return $this->render('content',['content'=>$content,'model'=>$model]);
    }
    public function actions()
    {
        return [

            'ueditor' => [
                'class' => 'crazyfd\ueditor\Upload',
                'config'=>[
                    'uploadDir'=>date('Y/m/d')
                ]

            ],
        ];
    }
}