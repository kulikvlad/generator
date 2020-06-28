<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int|null $number
 * @property int|null $chart_id
 * @property string|null $date
 * @property int|null $total
 * @property int|null $principle
 * @property int|null $interest
 * @property int|null $residuePrincipalDebt
 */
class Payments extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'chart_id', 'total', 'principle', 'interest', 'residuePrincipalDebt'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'chart_id' => 'Chart ID',
            'date' => 'Date',
            'total' => 'Total',
            'principle' => 'Principle',
            'interest' => 'Interest',
            'residuePrincipalDebt' => 'Residue Principal Debt',
        ];
    }
}
