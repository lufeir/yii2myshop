<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170608_083344_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('文章名称'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer(11)->comment('排序'),
            'status'=>$this->smallInteger(2)->comment('状态'),
            'article_category_id'=>$this->integer(100)->comment('类型'),
            'create_time'=>$this->integer(11)->comment('类型'),
        ]);
//            id primaryKey
//            name varchar﴿05﴾ 名称
//            intro text 简介
//            article_category_id int﴿﴾ 文章分类id
//            sort int﴿11﴾ 排序
//            status int﴿2﴾ 状态﴿常正1 藏隐0 除删1‐﴾
//            create_time int﴿11﴾ 创建时间
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
