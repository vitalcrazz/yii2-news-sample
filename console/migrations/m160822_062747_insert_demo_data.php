<?php

use yii\db\Migration;

class m160822_062747_insert_demo_data extends Migration
{
    public function up()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'auth_key' => 'wczBMhNmaoyPldfXbS0-96Jylc-1KnZK',
            'password_hash' => '$2y$13$LTHj17vLtiSVNmhETi41HO.uvCFHnfJ8Bte1Y3wwRPVF5TOJ3amf6',
            'email' => 'zojl@yandex.ru',
        ]);

        $adminId = Yii::$app->db->lastInsertID;

        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole('admin'), $adminId);

        $this->batchInsert('{{%subjects}}', ['name'], [
            ['Бизнес'],
            ['Культура'],
            ['Спорт'],
            ['Наука и техника'],
            ['Другие новости'],
        ]);
    }

    public function down()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);

        $this->delete('{{%news}}');

        $this->delete('{{%subjects}}');
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
