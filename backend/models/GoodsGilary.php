<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gilary".
 *
 * @property integer $goods_id
 * @property string $path
 */
class GoodsGilary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gilary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'required'],
            [['goods_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'goods_id' => 'Goods ID',
            'path' => '上传图片',
        ];
    }
}
