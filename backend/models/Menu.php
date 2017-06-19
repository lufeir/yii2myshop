<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $label
 * @property string $url
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
            [['label'],'required'],
        ];
    }
    public function valiadateM(){
        $menu=self::findOne(['label'=>$this->label]);
        if($menu){
            $this->addError('label','该菜单已存在');
        }else{
            return true;
        }
        return false;
    }
    public function valiadateE($id){
        $menu=self::findOne(['id'=>$id]);
        $meny1=self::findOne(['label'=>$this->label]);
        if($this->label!=$menu->label&& $meny1){
           $this->addError('label','该菜单已存在');
        }else{
            return true;
        }
        return false;
    }
    public static function getParent(){
     $meny=self::find()->asArray()->where(['parent_id'=>0])->all();

     if(!$meny){
         return [0=>'一级菜单'];
     }else{
          $meny[]=['id'=>'0','label'=>'一级菜单'];
         return ArrayHelper::map($meny,'id','label');
     }
    }

    /**
     * @inheritdoc
     */
    public function getChildren(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '上级菜单',
            'label' => '名称',
            'url' => '地址/路由',
            'sort' => '排序',
        ];
    }
}
