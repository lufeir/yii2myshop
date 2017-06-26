<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $content
 * @property string $user_name
 * @property string $tel
 * @property integer $status
 * @property integer $is_mo
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['member_id', 'status', 'is_mo'], 'integer'],
            [['province', 'content','city','district'], 'string', 'max' => 100],
            [['user_name'], 'string', 'max' => 20],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'province' => '收获地址：',
            'content' => '详细地址：',
            'user_name' => '收货人：',
            'tel' => '电话号码：',
            'status' => '状态',
            'is_mo' => ' ',
        ];
    }
}
