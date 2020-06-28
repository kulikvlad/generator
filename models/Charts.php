<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "charts".
 *
 * @property int $id
 * @property string|null $title
 */
class Charts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPayments()
    {
        return $this->hasMany(Payments::className(), ['chart_id' => 'id']);
    }
}
