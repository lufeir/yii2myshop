<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $brand_id
 * @property integer $is_on_sale
 * @property integer $sort
 * @property integer $create_time
 * @property integer $status
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    public function getCategory(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    public static function tableName()
    {
        return 'goods';
    }
    public function getGailarys(){
        return $this->hasMany(GoodsGilary::className(),['goods_id'=>'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_id', 'is_on_sale'], 'required'],
            [['goods_category_id', 'stock', 'brand_id', 'is_on_sale', 'sort', 'create_time', 'status'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['sn', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '简介',
            'logo' => 'LOGO',
            'goods_category_id' => '商品分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'brand_id' => '品牌分类',
            'is_on_sale' => '是否在售',
            'sort' => '排序',
            'create_time' => '创建时间',
            'status' => '商品状态',
        ];
    }
}
