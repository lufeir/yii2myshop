<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $password;//明文密码
    public $rePassword;//确认密码
    public $code;
    public $smsCode;//短信验证码
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_login_time', 'last_login_ip', 'created_at', 'updated_at', 'status'], 'integer'],
            [['username'], 'unique'],
            ['smsCode','required'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 100],
            [['email'],'email'],
            ['code','captcha'],
            [['tel'], 'string', 'max' => 11],
            ['password','safe'],
            ['rePassword','compare','compareAttribute'=>'password','message'=>'两次密码必须一样'],
            ['smsCode','valaditeSMS']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名：',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'email' => '邮箱：',
            'tel' => '电话：',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'status' => '状态',
            'password'=>'密码：',
            'rePassword'=>'确认密码：',
            'code'=>'验证码：',
            'smsCode'=>'短信验证码',
        ];
    }
   public function valaditeSMS(){
        $value=Yii::$app->cache->get('tel_'.$this->tel);
        if(!$value || $this->smsCode!=$value){
            $this->addError('smsCode','验证码不正确');
        }
   }
    public function beforeSave($insert)
    {
        //只在添加的时候设置
        //$insert = $this->getIsNewRecord();
        if($insert){
            $this->created_at= time();
            $this->status = 1;
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }else{
            //更新 ,如果密码被修改，则重新加密。如果密码没有改，不需要操作
            $oldPassword = $this->getOldAttribute('password_hash');//获取旧属性
            if($this->password_hash != $oldPassword){
                $this->password_hash= Yii::$app->security->generatePasswordHash($this->password);
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
     *
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

}
