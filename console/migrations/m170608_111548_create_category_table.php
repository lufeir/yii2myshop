<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170608_111548_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree'=>$this->integer()->comment('树id'),
            'lft'=>$this->integer()->comment('左值'),
            'rgt'=>$this->integer()->comment('右值'),
            'name'=>$this->string(50)->comment('名称'),
            'parent_id'=>$this->integer()->comment('父类ID'),
            'intro'=>$this->text()->comment('简介'),
//            id primaryKey
//            tree int﴿﴾ 树id
//            lft int﴿﴾ 左值
//            rgt int﴿﴾ 右值
//            depth int﴿﴾ 层级
//            name varchar﴿05﴾ 名称
//            parent_id int﴿﴾ 上级分类id
//            intro text﴿﴾ 简介
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
