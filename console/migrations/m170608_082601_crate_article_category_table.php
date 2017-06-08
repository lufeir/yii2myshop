<?php

use yii\db\Migration;

class m170608_082601_crate_article_category_table extends Migration
{
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('分类名称'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer(11)->comment('排序'),
            'status'=>$this->smallInteger(2)->comment('状态'),
            'is_help'=>$this->smallInteger(1)->comment('类型'),
        ]);
//            id primaryKey
//            name varchar﴿05﴾ 名称
//            intro text 简介
//            sort int﴿11﴾ 排序
//            status int﴿2﴾ 状态﴿常正1 藏隐0 除删1‐﴾
//            is_help int﴿1﴾ 类型

    }

    public function down()
    {
        echo "m170608_082601_crate_article_category_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
