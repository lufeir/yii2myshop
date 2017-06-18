<?php
/**
 * Created by PhpStorm.
 * User: 李政宇
 * Date: 2017/6/16
 * Time: 15:08
 */
namespace backend\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions=[];
    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['permissions','safe'],
        ];
    }
    public function attributeLabels()
    {
       return [
           'name'=>'名称',
           'description'=>'描述',
           'permissions'=>'选择权限',
       ];
    }
    public static function getPermissionOption(){
        $authManger=\Yii::$app->authManager;
        return ArrayHelper::map($authManger->getPermissions(),'name','description');
    }
    public function addRole(){
        $authManger=\Yii::$app->authManager;
        if($authManger->getRole($this->name)){
            $this->addError('name','角色已存在');
        }else{
            $role=$authManger->createRole($this->name);
            $role->description=$this->description;
            if($authManger->add($role)){//添加角色成功就关联角色
                foreach ($this->permissions as $permissionName){
                    $permission=$authManger->getPermission($permissionName);
                    if($permission)$authManger->addChild($role,$permission);//关联角色
                }
                return true;
            }

        }
        return false;
    }
    public function loadData(Role $role){
        $this->name=$role->name;
        $this->description=$role->description;
        $permissions=\Yii::$app->authManager->getPermissionsByRole($role->name);
        foreach ($permissions as $permission){
            $this->permissions[]=$permission->name;
        }
     }
     public function updateRole($name){
        $authManger=\Yii::$app->authManager;
        $role=$authManger->getRole($name);
        $role->name=$this->name;
        $role->description=$this->description;
        if($authManger->getRole($this->name) && $this->name!=$name){
            $this->addError('name','角色已存在');
        }else{
            if($authManger->update($name,$role)){
                $authManger->removeChildren($role);//去掉原有的角色的权限
                foreach ($this->permissions as $permissionName){
                    $permission=$authManger->getPermission($permissionName);
                    if($permission) $authManger->addChild($role,$permission);//重新将角色的权限关联
                }
                return true;
            }
        }
        return false;
     }
}