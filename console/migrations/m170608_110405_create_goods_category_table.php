<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170608_110405_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            //name	varchar(50)	名称
            'name'=>$this->string(20)->notNull()->comment('商品名称'),
//intro	text	简介
            'sn'=>$this->string()->comment('简介'),
//logo	varchar(255)	LOGO图片
            'logo'=>$this->string(255)->comment('LOGO'),
//sort	int(11)	排序
            'goods_category_id'=>$this->integer()->comment('商品分类ID'),
//status	int(2)	状态(-1删除 0隐藏 1正常)
            'market_price'=>$this->decimal(10,2)->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->comment('商品价格'),
            'stock'=>$this->integer()->comment('库存'),


//            id primaryKey
//            name varchar﴿02﴾ 商品名称
//            sn varchar﴿02﴾ 货号
//            logo varchar﴿552﴾ LOGO图片
//            goods_category_id int 商品分类id
//            brand_id int 品牌分类
//            market_price decimal﴿2,01﴾ 市场价格
//            shop_price decimal﴿2 ,01﴾ 商品价格
//            stock int 库存
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
