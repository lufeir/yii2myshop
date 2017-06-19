<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170618_031410_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'parent_id'=>$this->integer()->comment('上级菜单'),
            'label'=>$this->string(50)->comment('名称'),
            'url'=>$this->string(255)->comment('菜单链接'),
            'sort'=>$this->integer()->comment('排序'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
