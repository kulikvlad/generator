<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%charts}}`.
 */
class m200627_090749_create_charts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%charts}}', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%charts}}');
    }
}
