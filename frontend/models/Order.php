<?php

namespace frontend\models;

use backend\models\Goods;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $total
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static $delivery=[
        ['delivery_id'=>1,'delivery_name'=>'普通快递送货上门','delivery_price'=>10],
        ['delivery_id'=>2,'delivery_name'=>'特快专递','delivery_price'=>40],
        ['delivery_id'=>3,'delivery_name'=>'加急快递送货上门','delivery_price'=>40],
        ['delivery_id'=>4,'delivery_name'=>'平邮','delivery_price'=>10],
        ];
    public static $payment=[
        ['payment_id'=>1,'payment_name'=>'货到付款'],
        ['payment_id'=>2,'payment_name'=>'在线支付'],
        ['payment_id'=>3,'payment_name'=>'上门自提'],
        ['payment_id'=>4,'payment_name'=>'邮局汇款'],
        ];
    public static $statusOption=[
        0=>'已取消',1=>'待付款',2=>'代发货',3=>'已完成'
    ];
    public $address_id;
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function getOgoods(){
        return $this->hasMany(OrderGoods::className(),['order_id'=>'id']);
    }
    public function rules()
    {
        return [
            [['member_id','amount', 'delivery_id', 'payment_id', 'status', 'create_time','province', 'city', 'area','address_id'], 'safe'],
            [['delivery_price', 'total'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['delivery_name', 'payment_name'], 'string', 'max' => 30],
            [['trade_no'], 'string', 'max' => 100],
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
            'name' => '收货人',
            'province' => '省',
            'city' => '市',
            'area' => '县',
            'address' => '详细地址',
            'tel' => '电话号码',
            'delivery_id' => ' ',
            'delivery_name' => '配送方式id',
            'delivery_price' => '配送方式价格',
            'payment_id' => '支付方式id',
            'payment_name' => '支付方式名称',
            'total' => '订单金额',
            'status' => '订单状态',
            'trade_no' => '第三方支付交易号',
            'create_time' => '创建时间',
            'address_id' => ' ',
        ];
    }

}
