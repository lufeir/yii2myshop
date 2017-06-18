<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/16
 * Time: 14:22
 */
namespace backend\controllers;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RbacController extends Controller{
    public function actionAddPermission(){
        $model=new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addPermission()){
                \Yii::$app->session->setFlash('success','权限添加成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }
    public function actionPermissionIndex(){
        $models=\Yii::$app->authManager->getPermissions();
        return $this->render('permission-index',['models'=>$models]);
    }
    public function actionEditPermission($name){
        $Permission=\Yii::$app->authManager->getPermission($name);
        if($Permission==null){
            throw new  NotFoundHttpException('权限不存在');
        }
        $model=new PermissionForm();
        $model->loadData($Permission);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updatePermission($name)){
                \Yii::$app->session->setFlash('success','权限修改成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }
    public function actionDelPermission($name){
        $Permission=\Yii::$app->authManager->getPermission($name);
        if($Permission==null){
            throw new  NotFoundHttpException('权限不存在');
        }
        \Yii::$app->authManager->remove($Permission);
        \Yii::$app->session->setFlash('success','权限删除成功');
        return $this->redirect(['rbac/permission-index']);
    }
    public function actionAddRole(){
       $model=new RoleForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addRole()){
                \Yii::$app->session->setFlash('success','角色添加成功');
                return $this->redirect(['rbac/role-index']);
            }
        }
       return $this->render('add-role',['model'=>$model]);
    }
    public function actionRoleIndex(){
        $models=\Yii::$app->authManager->getRoles();
        return $this->render('role-index',['models'=>$models]);

    }
    public function actionEditRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        $model=new RoleForm();
        $model->loadData($role);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updateRole($name)){
                \Yii::$app->session->setFlash('success','角色修改成功');
                return $this->redirect(['rbac/role-index']);
            }
        }
        return $this->render('add-role',['model'=>$model]);
    }
    public function actionDelRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        \Yii::$app->authManager->remove($role);
        \Yii::$app->session->setFlash('success','角色删除成功');
        return $this->redirect(['rbac/role-index']);
    }

}