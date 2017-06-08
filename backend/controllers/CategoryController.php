<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/8
 * Time: 16:43
 */
namespace backend\controllers;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
//分类控制器
class CategoryController extends Controller{
    //添加分类的操作
    public function actionAdd(){
        //实例化分类模型类
        $model=new ArticleCategory();
        $request=new Request();
        if($request->isPost){//判断请求参数
            $model->load($request->post());//接受数据
            if($model->validate()){//验证请求
                $model->save();//保存数据
                \Yii::$app->session->setFlash('success','文章分类添加成功');//提示信息
                return $this->redirect(['category/index']);//跳转到主页
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //显示主页
    public function actionIndex(){
        $query=ArticleCategory::find()->where(['status'=>1])->orderBy('sort');//找到所有正常状态的数据
        $total=$query->count();//统计个数
        //调用分页工具
        $page=new Pagination(['defaultPageSize'=>2,
            'totalCount'=>$total
        ]);
        $models=$query->offset($page->offset)->limit($page->limit)->all();//获取每页数据
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    //修改分类的操作
    public function actionEdit($id){
        $model=ArticleCategory::findOne(['id'=>$id]);//获取要修改的分类对象
        $request=new Request();
        if($request->isPost){//判断请求参数
            $model->load($request->post());//接受表单数据
            if($model->validate()){//验证数据
                $model->save();//保存数据
                \Yii::$app->session->setFlash('success','文章分类修改成功');
                return $this->redirect(['category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        $model=ArticleCategory::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        return $this->redirect(['category/index']);
    }
}