<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Form extends Model
{

    public $date;
    public $numberMonths;
    public $amount;
    public $interestRate;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['date', 'numberMonths', 'amount', 'interestRate'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }


}
