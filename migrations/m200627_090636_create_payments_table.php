<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payments}}`.
 */
class m200627_090636_create_payments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(),
            'number'=>$this->integer(),
            'chart_id'=>$this->integer(),
            'date'=>$this->date(),
            'total'=>$this->string(),
            'principle'=>$this->string(),
            'interest'=>$this->string(),
            'residuePrincipalDebt'=>$this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payments}}');
    }
}
