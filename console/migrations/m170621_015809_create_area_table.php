<?php

use yii\db\Migration;

/**
 * Handles the creation of table `area`.
 */
class m170621_015809_create_area_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('area', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('用户id'),
            'name'=>$this->string(100)->comment('收获地址'),
            'content'=>$this->string(100)->comment('详细地址'),
            'user_name'=>$this->string(20)->comment('收货人'),
            'tel'=>$this->char(11)->comment('电话号码'),
            'status'=>$this->integer(2)->comment('状态'),
            'is_mo'=>$this->integer(2)->comment('默认地址'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('area');
    }
}
