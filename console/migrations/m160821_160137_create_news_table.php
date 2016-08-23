<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m160821_160137_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%subjects}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'publication_date' => $this->date()->notNull(),
            'subject_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

        $this->createIndex('news-publication_date', '{{%news}}', 'publication_date');

        $this->addForeignKey('fk-news-subject_id', '{{%news}}', 'subject_id', '{{%subjects}}', 'id');

        $this->addForeignKey('fk-news-author_id', '{{%news}}', 'author_id', '{{%user}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%news}}');

        $this->dropTable('{{%subjects}}');
    }
}
