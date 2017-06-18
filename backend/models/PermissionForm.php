<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/16
 * Time: 14:24
 */
namespace backend\models;
use yii\base\Model;
use yii\rbac\Permission;

class PermissionForm extends Model{
    public $name;
    public $description;
    public function rules()
    {
       return [
           [['name','description'],'required'],
       ];
    }
    public function attributeLabels()
    {
       return [
           'name'=>'名称',
           'description'=>'描述',

       ];
    }
    public function addPermission(){
        $authManmger=\Yii::$app->authManager;
        if($authManmger->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }else{
            $permission=$authManmger->createPermission($this->name);
            $permission->description=$this->description;
            return $authManmger->add($permission);
        }
        return false;
    }
    public function loadData(Permission $Permission){
        $this->name=$Permission->name;
        $this->description=$Permission->description;
    }
    public function updatePermission($name){
        $authManger=\Yii::$app->authManager;
        $Permisision= $authManger->getPermission($name);
        if($this->name !=$name && $authManger->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }else{
            $Permisision->name=$this->name;
            $Permisision->description=$this->description;
            return $authManger->update($name,$Permisision);
        }
        return false;
    }

}