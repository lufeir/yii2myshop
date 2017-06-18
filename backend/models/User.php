<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $last_login_ip
 * @property integer $last_login_time
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $password2;
    const  SCENARIO_ADD='add';
    const  SCENARIO_EDIT='edit';
    public $roles=[];
    public function scenarios()
    {
        $scenarios =  parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['password_hash','password2','username','email','logo','status','roles'];
        $scenarios[self::SCENARIO_EDIT] = ['username','email','logo','status','roles'];
        return $scenarios;
    }
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            [['password2','password_hash'],'required','on'=>self::SCENARIO_ADD],
            [['status', 'created_at', 'updated_at', 'last_login_time'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'last_login_ip'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['logo','roles'],'safe'],
            ['password2','compare','compareAttribute'=>'password_hash','message'=>'两次密码必须一样'],
        ];
    }
    //回显用户的角色
    public function loadData($id){
         $authManger=\Yii::$app->authManager;
         $roles=$authManger->getRolesByUser($id);
         foreach ($roles as $role){
             $this->roles[]=$role->name;
         }
    }
    public static function getRoles(){
        $authManmger=\Yii::$app->authManager;
        return ArrayHelper::map($authManmger->getRoles(),'name','description');
    }
    //直接给用户添加角色
   public function upRole($id){
        foreach ($this->roles as $roleName){
            $authManmger=\Yii::$app->authManager;
            $role=$authManmger->getRole($roleName);
            $authManmger->assign($role,$id);
        }
   }
   //修改用户的角色
   public function edRole($id){
         $authManmger=\Yii::$app->authManager;
         $authManmger->revokeAll($id);
         foreach ($this->roles as $roleName){
             $role=$authManmger->getRole($roleName);
             $authManmger->assign($role,$id);
         }
   }
    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password_hash' => '密码',
            'password2' => '确认密码',
            'email' => '邮箱',
            'status' => '账号状态',
            'logo' => 'LOGO',
            'roles'=>'角色',
        ];
    }

    public function beforeSave($insert)
    {
        //只在添加的时候设置
        //$insert = $this->getIsNewRecord();
        if($insert){
            $this->created_at= time();
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        }else{
            //更新 ,如果密码被修改，则重新加密。如果密码没有改，不需要操作
            $oldPassword = $this->getOldAttribute('password_hash');//获取旧属性
            if($this->password_hash != $oldPassword){
                $this->password_hash= Yii::$app->security->generatePasswordHash($this->password_hash);
            }
        }


        return parent::beforeSave($insert);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */


    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken'=>$token]);
    }
    public static function findByUsername($username){     //①
        return static::findOne(['username'=>$username]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
/**
<span style="white-space:pre">    </span> * Generates "remember me" authentication key
<span style="white-space:pre">    </span> */
    public function generateAuthKey()                    //③
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
        $this->save();
    }
}
